<?php
// Recharge requests retain the legacy contact table and historical records.
// Requests are unpaid; only the Stripe service can create confirmed paid orders.
function request_selection(int $planId, int $carrierId): ?array {
    $rows=$planId>0?all('SELECT p.id AS plan_id,p.carrier_id,p.name AS plan_name,p.price_cents,c.name AS carrier_name,c.slug FROM plans p JOIN carriers c ON c.id=p.carrier_id WHERE p.id=? AND p.active=1 AND c.active=1',[$planId]):all('SELECT p.id AS plan_id,p.carrier_id,p.name AS plan_name,p.price_cents,c.name AS carrier_name,c.slug FROM plans p JOIN carriers c ON c.id=p.carrier_id WHERE c.id=? AND p.active=1 AND c.active=1 ORDER BY p.sort_order,p.price_cents',[$carrierId]);
    foreach($rows as $p)if(catalog_product($p['slug'],$p['plan_name'])['selectable'])return $p;
    return null;
}
function request_authorized(string $reference): ?array {
    if (!preg_match('/^(?:MI-RQ-|DEMO-)[A-F0-9]{12}$/D',$reference)) return null;
    $access=$_SESSION['request_access'][$reference]??$_SESSION['demo_access'][$reference]??'';
    if (!$access) return null;
    $d=one('SELECT * FROM demo_submissions WHERE reference=?',[$reference]);
    return $d&&hash_equals($d['access_hash'],hash('sha256',$access)) ? $d : null;
}
function request_api(string $action): void {
    if ($_SERVER['REQUEST_METHOD']!=='POST') json_response(['error'=>'Method not allowed'],405);
    if (!request_checkout_enabled()) json_response(['error'=>'Online requests are currently unavailable.'],409);
    csrf_check();
    // Explicit allowlist: no endpoint accepts card numbers, expiry or CVC.
    $allowed=$action==='details'?['csrf','checkout_key','plan_id','carrier_id','name','email','phone','consent']:['csrf','reference'];
    if (array_diff(array_keys($_POST),$allowed)) throw new InvalidArgumentException('Only contact details may be submitted. Do not send card information.');
    limit('request-'.$action,30,900);
    if ($action==='complete') {
        $d=request_authorized(post('reference',32,true));
        if (!$d) throw new InvalidArgumentException('Your checkout session has expired. Please start again.');
        query('UPDATE demo_submissions SET completed_at=COALESCE(completed_at,UTC_TIMESTAMP()) WHERE id=?',[$d['id']]);
        json_response(['redirect'=>'/thank-you?request='.$d['reference']]);
    }
    $planId=integer('plan_id',0,PHP_INT_MAX);$carrierId=integer('carrier_id',1,PHP_INT_MAX);
    $p=request_selection($planId,$carrierId);
    if (!$p||(int)$p['carrier_id']!==$carrierId) throw new InvalidArgumentException('Please select an available carrier or plan.');
    $key=post('checkout_key',64,true);$selection=$carrierId.':'.$planId;
    if (!preg_match('/^[a-f0-9]{64}$/D',$key)||!hash_equals($_SESSION['request_keys'][$selection]??'',$key)) throw new InvalidArgumentException('Refresh checkout and try again.');
    $name=post('name',150,true);$email=valid_email(post('email',254,true));$mobile=phone(post('phone',30,true));
    if (post('consent',1)!=='1') throw new InvalidArgumentException('Please confirm your number and accept the terms and privacy policy.');
    $access=hash_hmac('sha256',$key,$_SESSION['csrf']);
    db()->beginTransaction();
    try {
        $d=one('SELECT * FROM demo_submissions WHERE checkout_key=? FOR UPDATE',[$key]);
        if (!$d) {
            $reference='MI-RQ-'.strtoupper(bin2hex(random_bytes(6)));
            query('INSERT INTO demo_submissions (reference,checkout_key,access_hash,carrier_name,plan_name,amount_cents,customer_name,email,customer_phone,recharge_phone,zip) VALUES (?,?,?,?,?,?,?,?,?,?,?)',[$reference,$key,hash('sha256',$access),$p['carrier_name'],$p['plan_name'],$p['price_cents'],$name,$email,$mobile,$mobile,'']);
            $d=one('SELECT * FROM demo_submissions WHERE id=?',[db()->lastInsertId()]);
        } elseif (!$d['completed_at']) {
            query('UPDATE demo_submissions SET customer_name=?,email=?,customer_phone=?,recharge_phone=? WHERE id=?',[$name,$email,$mobile,$mobile,$d['id']]);
        }
        db()->commit();
    } catch (Throwable $e) {if(db()->inTransaction())db()->rollBack();throw $e;}
    $_SESSION['request_access'][$d['reference']]=$access;
    $_SESSION['request_access']=array_slice($_SESSION['request_access'],-20,null,true);
    $_SESSION['request_last'][$selection]=$d['reference'];
    $_SESSION['recharge_phone']=$mobile;
    json_response(['reference'=>$d['reference'],'completed'=>(bool)$d['completed_at'],'redirect'=>'/thank-you?request='.$d['reference']]);
}
