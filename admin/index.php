<?php
declare(strict_types=1);
require dirname(__DIR__).'/includes/bootstrap.php';
require __DIR__.'/actions.php';
$path=rtrim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),'/');if($path==='/admin/index.php')$path='/admin';
$error='';
if($path==='/admin/login'){
    if(admin_user())redirect('/admin');
    if($_SERVER['REQUEST_METHOD']==='POST')try{
        csrf_check();limit('login-ip',20,900);$email=valid_email(post('email',254,true));limit('login-account',5,900,$email);$password=post('password',1024,true);
        $a=one('SELECT * FROM admins WHERE email=?',[$email]);$hash=$a['password_hash']??'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi';
        if(!$a||!password_verify($password,$hash))throw new InvalidArgumentException('The email or password is incorrect.');
        clear_limit('login-account',$email);
        session_regenerate_id(true);$_SESSION['csrf']=bin2hex(random_bytes(32));$_SESSION['admin_id']=(int)$a['id'];$_SESSION['admin_version']=$a['session_version'];$_SESSION['admin_seen']=time();redirect($a['must_change_password']?'/admin/password':'/admin');
    }catch(InvalidArgumentException $e){$error=$e->getMessage();}
    require __DIR__.'/login.php';exit;
}
$admin=require_admin();
if($_SERVER['REQUEST_METHOD']==='POST')try{admin_action($admin);}catch(InvalidArgumentException $e){$error=$e->getMessage();}catch(\Stripe\Exception\ApiErrorException $e){$error='Stripe could not complete this request. Check your configuration and Stripe dashboard before retrying.';}catch(\PHPMailer\PHPMailer\Exception $e){$error='SMTP test failed. Check your mail server, username, password and encryption settings.';}
if($admin['must_change_password']&&$path!=='/admin/password')redirect('/admin/password');
require __DIR__.'/views.php';
require __DIR__.'/requests.php';
if($path==='/admin/demos')redirect('/admin/requests');
if($path==='/admin/demo')redirect('/admin/request?id='.(int)($_GET['id']??0));
if($path==='/admin/export'){export_orders();exit;}
$views=['/admin/requests'=>'Checkout requests','/admin/request'=>'Request details','/admin'=>'Dashboard','/admin/orders'=>'Orders','/admin/order'=>'Order details','/admin/carriers'=>'Carriers','/admin/carrier'=>'Edit carrier','/admin/plans'=>'Plans','/admin/plan'=>'Edit plan','/admin/customers'=>'Customers','/admin/customer'=>'Customer history','/admin/settings'=>'Settings','/admin/password'=>'Change password','/admin/emails'=>'Email delivery'];
$title=$views[$path]??'Page not found';if(!isset($views[$path]))http_response_code(404);
admin_header($title,$path,$admin);
if($error)echo '<div class="notice danger" role="alert">'.e($error).'</div>';
match($path){'/admin/requests'=>requests_view(),'/admin/request'=>request_view(),'/admin'=>dashboard_view(),'/admin/orders'=>orders_view(),'/admin/order'=>order_view(),'/admin/carriers'=>carriers_view(),'/admin/carrier'=>carrier_view(),'/admin/plans'=>plans_view(),'/admin/plan'=>plan_view(),'/admin/customers'=>customers_view(),'/admin/customer'=>customer_view(),'/admin/settings'=>settings_view(),'/admin/password'=>password_view(),'/admin/emails'=>emails_view(),default=>print('<p>Page not found. <a href="/admin">Return to dashboard</a>.</p>')};
admin_footer();
