<?php
require_once ROOT.'/includes/requests.php';
$reference=$_GET['request']??$_GET['demo']??'';
$d=request_authorized(is_string($reference)?$reference:'');
if(!$d||!$d['completed_at'])redirect('/carriers');
page_header('Thank you — request received','Your recharge request has been received.');
?>
<section class="container section narrow"><div class="result-heading"><span class="result-icon"><?=icon('check')?></span><p class="eyebrow">REQUEST RECEIVED</p><h1>Thank you, <?=e($d['customer_name'])?>!</h1><p>Your recharge request has been saved. Our team will review your details and confirm the next steps.</p></div>
<div class="surface"><div class="order-states"><div><span>Payment</span><?=status_badge('awaiting_payment')?></div><div><span>Request</span><?=status_badge('submitted')?></div></div><p class="muted">No payment has been collected. Your recharge will be processed after payment is confirmed.</p><dl class="order-details">
<?php foreach(['Reference'=>$d['reference'],'Name'=>$d['customer_name'],'Email'=>$d['email'],'Phone number'=>format_phone($d['recharge_phone']),'Carrier'=>$d['carrier_name'],'Plan'=>$d['plan_name'],'Plan price'=>money($d['amount_cents'])] as $label=>$value):?><div><dt><?=e($label)?></dt><dd><?=e($value)?></dd></div><?php endforeach;?></dl><a class="button primary full" href="/track">Track your request <?=icon('arrow')?></a><a class="text-link request-home" href="/">Back to home</a></div></section><?php page_footer(); ?>
