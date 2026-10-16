<?php
require_once ROOT.'/includes/requests.php';
$p=request_selection((int)($_GET['plan']??0),(int)($_GET['carrier']??0));
if(!$p){http_response_code(404);require __DIR__.'/404.php';return;}
$selection=$p['carrier_id'].':'.$p['plan_id'];
$last=request_authorized($_SESSION['request_last'][$selection]??'');
if($last&&$last['completed_at'])unset($_SESSION['request_keys'][$selection]);
$_SESSION['request_keys'][$selection]??=bin2hex(random_bytes(32));
page_header('Checkout','Review your prepaid plan and enter your contact information.');
page_intro('YOUR NEXT TOP-UP','Let’s keep you connected.','Confirm your number, review your plan, and continue to payment.');
?>
<section class="container section compact">
<div class="flow-steps" aria-label="Checkout progress"><span class="current" id="request-step-details">1 · Your details</span><span id="request-step-payment">2 · Payment</span><span>3 · Confirmation</span></div>
<div class="checkout-grid request-grid"><div class="surface">
<form id="request-details-form" method="post" action="/api/checkout-request/details"><?=csrf()?>
<input type="hidden" name="checkout_key" value="<?=e($_SESSION['request_keys'][$selection])?>"><input type="hidden" name="plan_id" value="<?=(int)$p['plan_id']?>"><input type="hidden" name="carrier_id" value="<?=(int)$p['carrier_id']?>">
<h2>Your details</h2>
<label for="request-name">Full name</label><input id="request-name" name="name" autocomplete="name" maxlength="150" required>
<label for="request-email">Email address</label><input id="request-email" name="email" type="email" autocomplete="email" maxlength="254" required>
<label for="request-phone">Number to recharge</label><input id="request-phone" name="phone" type="tel" autocomplete="tel-national" maxlength="20" placeholder="(201) 555-0123" value="<?=e($_SESSION['recharge_phone']??'')?>" required aria-describedby="request-phone-help"><small id="request-phone-help">Enter your existing 10-digit US prepaid number.</small>
<label class="check-label"><input type="checkbox" name="consent" value="1" required><span>I confirm this number uses <?=e($p['carrier_name'])?> prepaid service, accept the <a href="/terms" target="_blank" rel="noopener">terms</a>, and agree to my contact details being saved to process this request under the <a href="/privacy" target="_blank" rel="noopener">privacy policy</a>.</span></label>
<button class="button primary full" id="request-continue" type="submit">Continue to payment <?=icon('arrow')?></button>
<noscript><p>Please enable JavaScript to continue checkout, or contact our team.</p></noscript>
</form>
<section id="request-payment" hidden aria-labelledby="request-payment-title">
<p class="eyebrow">PAYMENT DETAILS</p><h2 id="request-payment-title" tabindex="-1">Payment</h2><p id="request-review" class="payment-review"></p>
<div class="payment-method-card"><span class="square-icon"><?=icon('card')?></span><div><strong>Credit or debit card</strong><p>Visa · Mastercard · American Express</p></div><?=icon('lock')?></div>
<div id="payment-element" class="card-entry" role="group" aria-label="Card information" aria-describedby="card-entry-note">
<label for="payment-cardholder">Name on card</label><input id="payment-cardholder" type="text" autocomplete="off" maxlength="100" placeholder="Name as it appears on your card" required>
<label for="payment-number">Card number</label><input id="payment-number" type="text" inputmode="numeric" autocomplete="off" maxlength="23" placeholder="1234 5678 9012 3456" required>
<div class="form-grid"><div><label for="payment-expiry">Expiry date</label><input id="payment-expiry" type="text" inputmode="numeric" autocomplete="off" maxlength="7" placeholder="MM / YY" required></div><div><label for="payment-cvc">Security code</label><input id="payment-cvc" type="password" inputmode="numeric" autocomplete="off" maxlength="4" placeholder="CVC" required></div></div>
</div>
<p id="card-entry-note" class="muted card-entry-note">Card entries stay in this browser and are cleared when you continue. No payment is processed yet.</p>
<button type="button" class="button primary full" id="request-submit">Continue <?=icon('arrow')?></button><button type="button" class="text-link" id="request-edit">Edit contact details</button>
</section><p id="request-error" class="form-error" role="alert" hidden></p>
</div><aside class="order-summary surface"><p class="eyebrow">YOUR TOP-UP</p><h2><?=e($p['carrier_name'])?></h2><h3><?=e($p['plan_name'])?></h3><dl><div class="summary-total"><dt>Plan price</dt><dd><?=money($p['price_cents'])?></dd></div></dl><p class="muted">Applicable taxes, fees and account eligibility will be confirmed before payment.</p><div class="summary-trust"><?=icon('shield')?><span>One-time recharge.<br>No subscription from us.</span></div><a class="back-link" href="/carriers/<?=e($p['slug'])?>">← Change plan</a></aside></div>
</section><script defer src="<?=asset('request-checkout.min.js')?>"></script><?php page_footer(); ?>
