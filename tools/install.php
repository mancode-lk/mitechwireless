<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}
require dirname(__DIR__).'/includes/bootstrap.php';
if(query('SHOW TABLES')->fetchColumn())throw new RuntimeException('Install requires a completely empty database. Existing databases are never overwritten.');
$sql=file_get_contents(ROOT.'/sql/schema.sql');db()->exec($sql);
db()->exec(file_get_contents(ROOT.'/sql/demo.sql'));
db()->exec(file_get_contents(ROOT.'/sql/selected-carriers.sql'));
$password=bin2hex(random_bytes(12)).'!Mi';
query('INSERT INTO admins (email,password_hash,must_change_password) VALUES (?,?,1)',['info@mitechwireless.com',password_hash($password,PASSWORD_DEFAULT)]);
$out=getenv('MITECH_CREDENTIAL_OUTPUT');
if(!$out)throw new RuntimeException('MITECH_CREDENTIAL_OUTPUT must point to a private file outside the site root.');
$document="# MI Tech Wireless — private administrator access\n\nAdmin URL: ".$config['base_url']."/admin\n\nEmail: info@mitechwireless.com\n\nTemporary password: ".$password."\n\nYou must change this password on first sign-in. Do not upload or share this file.\n";
file_put_contents($out,$document);chmod($out,0600);
echo 'Installed '.query('SELECT COUNT(*) FROM carriers')->fetchColumn().' carriers and '.query('SELECT COUNT(*) FROM plans')->fetchColumn()." unverified plans. Checkout disabled. Credentials saved privately.\n";
