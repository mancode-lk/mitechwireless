<?php
declare(strict_types=1);
require dirname(__DIR__).'/includes/bootstrap.php';
require ROOT.'/includes/layout.php';
$path=rtrim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)?:'/','/')?:'/';
if(in_array($path,['/api/checkout-request/details','/api/checkout-request/complete','/api/demo/details','/api/demo/complete'],true)){
    require_once ROOT.'/includes/requests.php';
    try{request_api(basename($path));}catch(InvalidArgumentException $e){json_response(['error'=>$e->getMessage()],422);}
}
if($path==='/api/webhook')webhook();
if($path==='/api/checkout'){
    if($_SERVER['REQUEST_METHOD']!=='POST')json_response(['error'=>'Method not allowed'],405);
    try{checkout_intent();}catch(InvalidArgumentException $e){json_response(['error'=>$e->getMessage()],422);}catch(\Stripe\Exception\ApiErrorException $e){json_response(['error'=>'We could not connect to the payment service. Please try again shortly.'],503);}
}
if($path==='/start'){
    if($_SERVER['REQUEST_METHOD']!=='POST')redirect('/');
    try{csrf_check();$mobile=phone(post('phone',30,true));$carrier=one('SELECT slug FROM carriers WHERE id=? AND active=1',[integer('carrier',1,PHP_INT_MAX)]);if(!$carrier)throw new InvalidArgumentException('Please choose a carrier.');$_SESSION['recharge_phone']=$mobile;redirect('/carriers/'.$carrier['slug']);}
    catch(InvalidArgumentException $e){flash($e->getMessage());redirect('/#recharge');}
}
$error='';$order=null;$request=null;
if($path==='/track'&&$_SERVER['REQUEST_METHOD']==='POST'){
    try{csrf_check();limit('track',10,900);$email=valid_email(post('email',254,true));$number=strtoupper(post('order_number',32,true));$order=one('SELECT * FROM orders WHERE order_number=? AND email=?',[$number,$email]);if(!$order)$request=one('SELECT * FROM demo_submissions WHERE reference=? AND email=? AND completed_at IS NOT NULL',[$number,$email]);if(!$order&&!$request)throw new InvalidArgumentException('We couldn’t find a matching order or request. Check your reference and email.');}
    catch(InvalidArgumentException $e){$error=$e->getMessage();}
}
if($path==='/')require __DIR__.'/home.php';
elseif($path==='/carriers')require __DIR__.'/carriers.php';
elseif(preg_match('~^/carriers/([a-z0-9-]+)$~D',$path,$m)){$carrier=one('SELECT * FROM carriers WHERE slug=? AND active=1',[$m[1]]);if($carrier)require __DIR__.'/plans.php';else require __DIR__.'/404.php';}
elseif($path==='/checkout')require __DIR__.'/checkout.php';
elseif($path==='/thank-you')require __DIR__.'/thank-you.php';
elseif($path==='/track')require __DIR__.'/track.php';
elseif(in_array($path,['/faq','/about','/contact','/terms','/privacy','/refund-policy'],true))require __DIR__.'/pages.php';
else require __DIR__.'/404.php';
