<?php
function stripe_client(?string $mode=null): \Stripe\StripeClient {
    $key=secret('stripe_'.($mode??stripe_mode()).'_secret');if($key==='')throw new RuntimeException('Stripe is not configured');
    return new \Stripe\StripeClient(['api_key'=>$key,'max_network_retries'=>2]);
}
function queue_email(int $id,string $kind,string $recipient): void {query('INSERT IGNORE INTO email_queue (order_id,kind,recipient) VALUES (?,?,?)',[$id,$kind,$recipient]);}
function reconcile_payment(string $paymentId,string $mode): void {
    db()->beginTransaction();
    try {
        $o=one('SELECT * FROM orders WHERE payment_id=? FOR UPDATE',[$paymentId]);
        if(!$o){db()->rollBack();return;}
        // Read Stripe only after acquiring the per-order lock, so a delayed worker
        // cannot write an older payment snapshot over a newer confirmed refund.
        $pi=stripe_client($mode)->paymentIntents->retrieve($paymentId,['expand'=>['latest_charge']]);
        if($o['stripe_mode']!==$mode||$pi->livemode!==($mode==='live')||(int)$pi->amount!==(int)$o['amount_cents']||$pi->currency!=='usd'||($pi->metadata->order_number??'')!==$o['order_number'])throw new RuntimeException('Payment integrity check failed');
        $charge=$pi->latest_charge; $refunded=is_object($charge)?(int)$charge->amount_refunded:0;
        $paid=$pi->status==='succeeded';
        $status=$paid?'paid':($pi->status==='canceled'?'failed':(($pi->status==='requires_payment_method'&&$pi->last_payment_error)?'failed':'pending'));
        if($refunded>0)$status=$refunded>=(int)$o['amount_cents']?'refunded':'partially_refunded';
        // A stale/non-terminal event must never downgrade a confirmed payment or refund.
        if(in_array($o['payment_status'],['paid','partially_refunded','refunded'],true)&&!$paid){db()->commit();return;}
        $recharge=$o['recharge_status'];if($paid&&$recharge==='awaiting_payment')$recharge='processing';
        if($status==='refunded')$recharge='refunded';
        $card=is_object($charge)?($charge->payment_method_details->card??null):null;
        query('UPDATE orders SET payment_status=?,recharge_status=?,card_brand=?,card_last4=?,refunded_cents=?,paid_at=IF(?=1,COALESCE(paid_at,UTC_TIMESTAMP()),paid_at) WHERE id=?',[$status,$recharge,$card->brand??'',$card->last4??'',$refunded,$paid?1:0,$o['id']]);
        if($status!==$o['payment_status'])history((int)$o['id'],$status,'Stripe confirmed payment status: '.$status.'.');
        if($paid){queue_email((int)$o['id'],'receipt',$o['email']);queue_email((int)$o['id'],'admin_alert',setting('support_email','info@mitechwireless.com'));}
        db()->commit();
    }catch(Throwable $e){if(db()->inTransaction())db()->rollBack();throw $e;}
}
function checkout_intent(): void {
    csrf_check();limit('checkout',10,900);
    if(!checkout_ready())throw new InvalidArgumentException('Online payments are not available yet. Please contact our support team.');
    $planId=integer('plan_id',1,PHP_INT_MAX);
    $p=one('SELECT p.*,c.name AS carrier_name,c.active AS carrier_active FROM plans p JOIN carriers c ON c.id=p.carrier_id WHERE p.id=?',[$planId]);
    if(!$p||!$p['active']||!$p['carrier_active']||$p['verify_pricing'])throw new InvalidArgumentException('This plan is not currently available for purchase.');
    $name=post('name',150,true);$email=valid_email(post('email',254,true));$mobile=phone(post('phone',30,true));$contact=phone(post('customer_phone',30,true));$zip=post('zip',10,true);
    if(!preg_match('/^\d{5}(?:-\d{4})?$/D',$zip))throw new InvalidArgumentException('Enter a valid US ZIP code.');
    if(post('terms',4)!=='1')throw new InvalidArgumentException('Please accept the terms and confirm the prepaid number and carrier.');
    $mode=stripe_mode();$requestKey=post('checkout_key',64,true);
    if(!preg_match('/^[a-f0-9]{64}$/D',$requestKey)||!hash_equals($_SESSION['checkout_key']??'',$requestKey))throw new InvalidArgumentException('Refresh checkout and try again.');
    // Browser retries reuse this order and the same Stripe idempotency key. A changed cart starts a new order.
    $key=hash('sha256',$requestKey.'|'.json_encode([$planId,$name,$email,$mobile,$contact,$zip,$mode]));
    $access=hash_hmac('sha256',$key, $_SESSION['csrf']);
    db()->beginTransaction();
    try {
        $o=one('SELECT * FROM orders WHERE checkout_key=? FOR UPDATE',[$key]);
        if(!$o){
            // Email ownership is not verified in guest checkout. Preserve an existing
            // customer's profile; this order keeps its own submitted details.
            query('INSERT INTO customers (email,name,phone,zip) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)',[$email,$name,$contact,$zip]);
            $customer=one('SELECT id FROM customers WHERE email=?',[$email]);$orderNumber='MI-'.strtoupper(bin2hex(random_bytes(6)));
            query('INSERT INTO orders (order_number,customer_id,carrier_id,plan_id,customer_name,email,customer_phone,recharge_phone,zip,carrier_name,plan_name,plan_description,amount_cents,stripe_mode,access_hash,checkout_key,notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$orderNumber,$customer['id'],$p['carrier_id'],$p['id'],$name,$email,$contact,$mobile,$zip,$p['carrier_name'],$p['name'],$p['description'],$p['price_cents'],$mode,hash('sha256',$access),$key,'']);
            $o=one('SELECT * FROM orders WHERE id=?',[db()->lastInsertId()]);history((int)$o['id'],'awaiting_payment','Order created. Payment confirmation pending.');
        }
        db()->commit();
    }catch(Throwable $e){if(db()->inTransaction())db()->rollBack();throw $e;}
    if($o['payment_id'])$pi=stripe_client($mode)->paymentIntents->retrieve($o['payment_id']);
    else{
        $pi=stripe_client($mode)->paymentIntents->create(['amount'=>(int)$o['amount_cents'],'currency'=>'usd','payment_method_types'=>['card'],'metadata'=>['order_number'=>$o['order_number']]],['idempotency_key'=>'mitech-'.$o['order_number']]);
        query('UPDATE orders SET payment_id=? WHERE id=? AND payment_id IS NULL',[$pi->id,$o['id']]);
    }
    $_SESSION['order_access'][$o['order_number']]=$access;
    $_SESSION['last_checkout_order']=$o['order_number'];
    json_response(['client_secret'=>$pi->client_secret,'order_number'=>$o['order_number'],'publishable_key'=>setting('stripe_'.$mode.'_publishable')]);
}
function authorized_order(string $number): ?array {
    $o=one('SELECT * FROM orders WHERE order_number=?',[$number]);
    return $o&&hash_equals($o['access_hash'],hash('sha256',$_SESSION['order_access'][$number]??''))?$o:null;
}
function webhook(): void {
    if($_SERVER['REQUEST_METHOD']!=='POST')json_response(['error'=>'Method not allowed'],405);
    $payload=file_get_contents('php://input');if(strlen($payload)>1000000)json_response(['error'=>'Payload too large'],413);
    $sig=$_SERVER['HTTP_STRIPE_SIGNATURE']??'';$event=null;$mode='';
    foreach(['test','live'] as $candidate){$key=secret('stripe_'.$candidate.'_webhook');if($key==='')continue;
        try{$ev=\Stripe\Webhook::constructEvent($payload,$sig,$key);if($ev->livemode===($candidate==='live')){$event=$ev;$mode=$candidate;break;}}catch(UnexpectedValueException|\Stripe\Exception\SignatureVerificationException $ignored){}
    }
    if(!$event)json_response(['error'=>'Invalid signature'],400);
    if(one('SELECT event_id FROM webhook_events WHERE event_id=?',[$event->id]))json_response(['received'=>true]);
    $obj=$event->data->object;$paymentId='';
    if(in_array($event->type,['payment_intent.succeeded','payment_intent.payment_failed','payment_intent.canceled','payment_intent.processing'],true))$paymentId=$obj->id;
    if(in_array($event->type,['charge.refunded','charge.refund.updated'],true))$paymentId=$obj->payment_intent??'';
    if(in_array($event->type,['refund.created','refund.updated','refund.failed'],true))$paymentId=$obj->payment_intent??'';
    if($paymentId!=='')reconcile_payment($paymentId,$mode);
    query('INSERT IGNORE INTO webhook_events (event_id) VALUES (?)',[$event->id]);
    json_response(['received'=>true]);
}
