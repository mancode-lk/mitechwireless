<?php
function db(): PDO {
    static $db; global $config;
    return $db ??= new PDO($config['dsn'],$config['db_user'],$config['db_password'],[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false]);
}
function query(string $sql,array $params=[]): PDOStatement {$q=db()->prepare($sql);$q->execute($params);return $q;}
function all(string $sql,array $params=[]): array {return query($sql,$params)->fetchAll();}
function one(string $sql,array $params=[]): ?array {return query($sql,$params)->fetch()?:null;}
function e($value): string {return htmlspecialchars(is_scalar($value)?(string)$value:'',ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function money($cents): string {return '$'.number_format((int)$cents/100,2);}
function when(?string $date): string {global $config;return $date?(new DateTimeImmutable($date,new DateTimeZone('UTC')))->setTimezone(new DateTimeZone($config['timezone']))->format('m/d/Y g:i A T'):'—';}
function settings(): array {static $s;return $s??=array_column(all('SELECT `key`,`value` FROM settings'),'value','key');}
function setting(string $key,string $default=''): string {return settings()[$key]??$default;}
function save_setting(string $key,string $value): void {query('INSERT INTO settings (`key`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)',[$key,$value]);}
function seal(string $value): string {
    if($value==='')return ''; global $config;$iv=random_bytes(12);$tag='';
    $cipher=openssl_encrypt($value,'aes-256-gcm',hex2bin($config['app_key']),OPENSSL_RAW_DATA,$iv,$tag);
    if($cipher===false)throw new RuntimeException('Encryption failed');return base64_encode($iv.$tag.$cipher);
}
function secret(string $key): string {
    $raw=base64_decode(setting($key),true);if(!$raw||strlen($raw)<29)return '';global $config;
    $v=openssl_decrypt(substr($raw,28),'aes-256-gcm',hex2bin($config['app_key']),OPENSSL_RAW_DATA,substr($raw,0,12),substr($raw,12,16));
    if($v===false)throw new RuntimeException('Cannot decrypt settings');return $v;
}
function csrf(): string {return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">';}
function csrf_check(): void {if(!is_string($_POST['csrf']??null)||!hash_equals($_SESSION['csrf'],$_POST['csrf'])) throw new InvalidArgumentException('Your session expired. Refresh this page and try again.');}
function post(string $name,int $max=500,bool $required=false): string {
    $v=$_POST[$name]??'';if(!is_string($v)||mb_strlen($v)>$max)throw new InvalidArgumentException('Please check the '.str_replace('_',' ',$name).' field.');
    $v=trim($v);if($required&&$v==='')throw new InvalidArgumentException('Please enter '.str_replace('_',' ',$name).'.');return $v;
}
function phone(string $v): string {
    if(!preg_match('/^[+0-9 ().-]+$/D',$v))throw new InvalidArgumentException('Enter a valid US mobile number.');
    $v=preg_replace('/\D/','',$v);if(strlen($v)===11&&$v[0]==='1')$v=substr($v,1);
    if(!preg_match('/^[2-9][0-9]{2}[2-9][0-9]{6}$/D',$v))throw new InvalidArgumentException('Enter a 10-digit US mobile number, with or without +1.');
    $util=\libphonenumber\PhoneNumberUtil::getInstance();
    try{$number=$util->parse('+1'.$v,'US');}catch(\libphonenumber\NumberParseException $e){throw new InvalidArgumentException('Enter a valid US mobile number.');}
    if(!$util->isValidNumberForRegion($number,'US'))throw new InvalidArgumentException('Only eligible United States numbers are supported.');
    return $v;
}
function format_phone(string $v): string {return strlen($v)===10?'('.substr($v,0,3).') '.substr($v,3,3).'-'.substr($v,6):$v;}
function valid_email(string $v): string {$v=strtolower(trim($v));if(strlen($v)>254||!filter_var($v,FILTER_VALIDATE_EMAIL))throw new InvalidArgumentException('Enter a valid email address.');return $v;}
function integer(string $name,int $min,int $max): int {$v=post($name,20,true);if(!ctype_digit($v)||(int)$v<$min||(int)$v>$max)throw new InvalidArgumentException('Check '.str_replace('_',' ',$name).'.');return (int)$v;}
function price(string $v): int {if(!preg_match('/^\d{1,4}(\.\d{1,2})?$/D',$v))throw new InvalidArgumentException('Enter a valid price in USD.');$c=(int)round((float)$v*100);if($c<100||$c>200000)throw new InvalidArgumentException('Price must be between $1 and $2,000.');return $c;}
function redirect(string $path): void {header('Location: '.$path,true,303);exit;}
function flash(string $msg): void {$_SESSION['flash']=$msg;}
function json_response(array $body,int $code=200): void {http_response_code($code);header('Content-Type: application/json');echo json_encode($body,JSON_UNESCAPED_SLASHES);exit;}
function limit(string $scope,int $max,int $seconds,string $identity=''): void {
    global $config;$bucket=hash_hmac('sha256',$scope.'|'.($identity?:($_SERVER['REMOTE_ADDR']??'cli')),$config['app_key']);$now=time();
    query('INSERT INTO rate_limits (bucket,attempts,expires_at) VALUES (?,1,?) ON DUPLICATE KEY UPDATE attempts=IF(expires_at<=?,1,attempts+1), expires_at=IF(expires_at<=?, ?, expires_at)',[$bucket,$now+$seconds,$now,$now,$now+$seconds]);
    if((int)one('SELECT attempts FROM rate_limits WHERE bucket=?',[$bucket])['attempts']>$max)throw new InvalidArgumentException('Too many attempts. Please try again later.');
}
function clear_limit(string $scope,string $identity): void {global $config;query('DELETE FROM rate_limits WHERE bucket=?',[hash_hmac('sha256',$scope.'|'.$identity,$config['app_key'])]);}
function admin_user(): ?array {
    if(empty($_SESSION['admin_id']))return null;
    if(time()-($_SESSION['admin_seen']??0)>1800){unset($_SESSION['admin_id']);return null;}
    $a=one('SELECT id,email,must_change_password,session_version FROM admins WHERE id=?',[$_SESSION['admin_id']]);
    if(!$a||$a['session_version']!==($_SESSION['admin_version']??null)){unset($_SESSION['admin_id']);return null;}
    $_SESSION['admin_seen']=time();return $a;
}
function require_admin(): array {$a=admin_user();if(!$a)redirect('/admin/login');return $a;}
function history(int $id,string $status,string $msg,?int $admin=null): void {query('INSERT INTO order_status_history (order_id,status,message,admin_id) VALUES (?,?,?,?)',[$id,$status,$msg,$admin]);}
function stripe_mode(): string {return setting('stripe_mode','test')==='live'?'live':'test';}
function request_checkout_enabled(): bool {return setting('request_checkout_enabled',setting('demo_checkout_enabled','0'))==='1';}
function demo_enabled(): bool {return request_checkout_enabled();}
function checkout_ready(): bool {return !request_checkout_enabled() && setting('checkout_enabled')==='1' && setting('stripe_'.stripe_mode().'_publishable')!=='' && secret('stripe_'.stripe_mode().'_secret')!=='' && secret('stripe_'.stripe_mode().'_webhook')!=='';}
function asset(string $name): string {return '/assets/'.$name.'?v=20261015-card2';}
function catalog_product(string $slug,string $name): array {
    static $products;
    if($products===null){$products=[];$path=ROOT.'/research/expanded-catalog.json';$catalog=is_file($path)?json_decode(file_get_contents($path),true):[];foreach($catalog['carriers']??[] as $c)foreach($c['plans'] as $p)$products[$c['slug']][$p['name']]=$p;}
    return $products[$slug][$name]??['category'=>'monthly','period_label'=>'','eligibility'=>'','selectable'=>true,'source_url'=>''];
}
function status_badge(string $s): string {return '<span class="status status-'.e($s).'">'.e(ucwords(str_replace('_',' ',$s))).'</span>';}
function icon(string $name,string $class=''): string {
 $paths=['arrow'=>'<path d="M5 12h14m-5-5 5 5-5 5"/>','check'=>'<path d="m5 12 4 4L19 6"/>','lock'=>'<rect x="5" y="10" width="14" height="11" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>','phone'=>'<rect x="7" y="2" width="10" height="20" rx="3"/><path d="M10 18h4"/>','search'=>'<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/>','chevron'=>'<path d="m8 5 7 7-7 7"/>','mail'=>'<rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3 6 9 7 9-7"/>','globe'=>'<circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>','clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>','menu'=>'<path d="M4 6h16M4 12h16M4 18h16"/>','shield'=>'<path d="m12 2 8 3v6c0 5-8 11-8 11S4 16 4 11V5z"/><path d="m8 11 3 3 5-6"/>','card'=>'<rect x="2" y="4" width="20" height="16" rx="3"/><path d="M2 9h20M6 15h4"/>','bolt'=>'<path d="m13 2-9 12h7l-1 8L20 9h-7z"/>','bag'=>'<rect x="4" y="7" width="16" height="14" rx="3"/><path d="M8 7V6a4 4 0 0 1 8 0v1"/>'];
 return '<svg class="icon '.e($class).'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($paths[$name]??$paths['check']).'</svg>';
}
function carrier_logo(array $c): string {
 if(preg_match('~^/assets/carriers/(?:simple-mobile|t-mobile|lyca-mobile|ultra-mobile|h2o-wireless|att)\.(?:svg|png|webp)$~D',$c['logo']))return '<img class="official-carrier-logo" src="'.e($c['logo']).'" alt="'.e($c['name']).'" width="180" height="64" loading="lazy">';
 if($c['logo']!==''&&preg_match('~^/assets/uploads/[a-z0-9-]+\.(png|webp|jpg)$~D',$c['logo']))return '<img src="'.e($c['logo']).'" alt="'.e($c['name']).'" width="140" height="44" loading="lazy">';
 $color=preg_match('/^#[0-9a-f]{6}$/i',$c['color'])?$c['color']:'#222222';
 $rgb=array_map('hexdec',str_split(substr($color,1),2));
 for($i=0;$i<20;$i++){$linear=array_map(fn($v)=>$v/255<=.04045?($v/255)/12.92:(($v/255+.055)/1.055)**2.4,$rgb);$contrast=1.05/(.2126*$linear[0]+.7152*$linear[1]+.0722*$linear[2]+.05);if($contrast>=4.5)break;$rgb=array_map(fn($v)=>(int)round($v*.9),$rgb);}
 $color=sprintf('#%02x%02x%02x',...$rgb);
 return '<span class="carrier-wordmark" style="--carrier:'.e($color).'">'.e($c['name']).'</span>';
}
function faq_items(): array {return json_decode(setting('faqs','[]'),true)?:[];}
