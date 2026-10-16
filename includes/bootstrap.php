<?php
declare(strict_types=1);
const ROOT = __DIR__.'/..';
ini_set('display_errors', '0');
ini_set('log_errors', '1');
set_exception_handler(function(Throwable $e): void {
    $ref = bin2hex(random_bytes(4));
    // Do not log request bodies, customer details, processor secrets, or SQL values.
    error_log('MI Tech error '.$ref.' '.get_class($e).' at '.basename($e->getFile()).':'.$e->getLine());
    if(PHP_SAPI==='cli'){fwrite(STDERR,'MI Tech error '.$ref.' at '.basename($e->getFile()).':'.$e->getLine().PHP_EOL);exit(1);}
    http_response_code(500);
    if (str_starts_with(parse_url($_SERVER['REQUEST_URI']??'',PHP_URL_PATH)?:'', '/api/')) {
        header('Content-Type: application/json'); echo json_encode(['error'=>'We could not complete this request. Please try again.','reference'=>$ref]);
    } else echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>MI Tech Wireless</title><body style="font:18px system-ui;padding:8vw"><h1>We’ll be right back.</h1><p>Please try again shortly or contact info@mitechwireless.com.</p><p>Reference: '.htmlspecialchars($ref).'</p></body></html>';
});
$configPath=getenv('MITECH_CONFIG') ?: dirname(__DIR__,2).'/mitechwireless-private/config.php';
if (!is_file($configPath)) $configPath=ROOT.'/config/local.php';
if (!is_file($configPath)) throw new RuntimeException('Private configuration is not installed');
$config=require $configPath;
date_default_timezone_set('UTC');
require ROOT.'/vendor/autoload.php';
require __DIR__.'/functions.php';
if(PHP_SAPI!=='cli') {
    ini_set('session.use_strict_mode','1'); ini_set('session.use_only_cookies','1');
    session_name('MITECH_SESSION');
    session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>($config['environment']==='production'),'httponly'=>true,'samesite'=>'Lax']);
    session_start();
    if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff'); header('Referrer-Policy: same-origin'); header('X-Frame-Options: SAMEORIGIN');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://js.stripe.com; style-src 'self' 'unsafe-inline'; img-src 'self' data: https://*.stripe.com; font-src 'self'; connect-src 'self' https://api.stripe.com https://*.stripe.com; frame-src https://js.stripe.com https://hooks.stripe.com; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'");
}
require __DIR__.'/payments.php';
require __DIR__.'/mail.php';
