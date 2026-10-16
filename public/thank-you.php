<?php
if(isset($_GET['request'])||isset($_GET['demo'])){require __DIR__.'/request-thank-you.php';return;}
$number=is_string($_GET['order']??null)?$_GET['order']:'';$o=authorized_order($number);
if(!$o){redirect('/track');}
if($o['payment_id']&&$o['payment_status']==='pending'){
    try{limit('payment-status',20,300);reconcile_payment($o['payment_id'],$o['stripe_mode']);$o=authorized_order($number);}catch(\Stripe\Exception\ApiErrorException|InvalidArgumentException $ignored){}
}
$paid=in_array($o['payment_status'],['paid','partially_refunded','refunded'],true);page_header($paid?'Payment received':'Payment status'); ?>
<section class="container section narrow"><div class="result-heading"><span class="result-icon"><?=icon($paid?'check':'clock')?></span><p class="eyebrow">ORDER <?=e($o['order_number'])?></p><h1><?=$paid?'Thank you for your payment.':'We’re checking your payment.'?></h1><p><?=$paid?'Your order details are below. Recharge status is tracked separately from payment.':'Your payment has not yet been confirmed. Do not pay again if your bank has already authorized it; check this order or contact support.'?></p></div><div class="surface"><?php if($o['stripe_mode']==='test'):?><div class="notice">Test order — no real recharge.</div><?php endif;order_details($o);?><p class="muted">We’ll send a payment receipt and a separate email when your recharge is completed.</p><a class="button primary full" href="/track">Track your order <?=icon('arrow')?></a></div></section><?php page_footer(); ?>
