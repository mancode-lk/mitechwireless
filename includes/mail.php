<?php
function mailer(): \PHPMailer\PHPMailer\PHPMailer {
    $m=new \PHPMailer\PHPMailer\PHPMailer(true);$m->isSMTP();$m->Host=setting('smtp_host');
    if($m->Host==='')throw new RuntimeException('SMTP is not configured');
    $m->SMTPAuth=true;$m->Username=setting('smtp_username');$m->Password=secret('smtp_password');
    $m->Port=(int)setting('smtp_port','587');$m->SMTPSecure=setting('smtp_security','tls')==='ssl'?\PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS:\PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $m->Timeout=15;$m->CharSet='UTF-8';$m->setFrom(setting('sender_email','info@mitechwireless.com'),setting('site_name','MI Tech Wireless'));
    $m->addReplyTo(setting('support_email','info@mitechwireless.com'));$m->isHTML(true);return $m;
}
function email_body(array $o,string $kind): array {
    $title=match($kind){'completed'=>'Your recharge is complete','admin_alert'=>'New paid recharge order',default=>'Thank you for your payment'};
    $intro=match($kind){'completed'=>'Our team has marked your prepaid recharge as complete. Thank you for choosing MI Tech Wireless.','admin_alert'=>'Payment is confirmed. This order is waiting for manual recharge fulfillment.',default=>'Your payment has been received. Your recharge is now processing with our team. Payment confirmation does not mean the phone has already been recharged.'};
    global $config;$rows=['Order ID'=>$o['order_number'],'Mobile number'=>format_phone($o['recharge_phone']),'Carrier'=>$o['carrier_name'],'Plan'=>$o['plan_name'],'Amount'=>money($o['amount_cents']),'Date'=>when($o['paid_at']??$o['created_at']),'Status'=>$kind==='completed'?'Recharged':ucwords(str_replace('_',' ',$o['recharge_status']))];
    $table='';foreach($rows as $key=>$value)$table.='<tr><td style="padding:10px;border-bottom:1px solid #eee;color:#667085">'.e($key).'</td><td style="padding:10px;border-bottom:1px solid #eee;font-weight:600">'.e($value).'</td></tr>';
    $test=$o['stripe_mode']==='test'?'<p style="color:#a45108;font-weight:bold">TEST ORDER — no real charge or recharge.</p>':'';
    $body='<html><body style="margin:0;background:#f5f5f7;font:16px Arial,sans-serif;color:#17191d"><table role="presentation" width="100%"><tr><td style="padding:32px 16px"><table role="presentation" style="max-width:600px;width:100%;margin:auto;background:white;border-radius:16px"><tr><td style="padding:32px"><p style="font-size:20px;font-weight:900;color:#df1825">MI TECH WIRELESS</p>'.$test.'<h1 style="font-size:26px">'.e($title).'</h1><p style="line-height:1.7">'.e($intro).'</p><table style="width:100%;border-collapse:collapse">'.$table.'</table><p style="margin-top:28px"><a style="display:inline-block;background:#df1825;color:white;padding:14px 22px;text-decoration:none;border-radius:8px" href="'.e($config['base_url'].'/track').'">Track your order</a></p><p style="font-size:13px;color:#667085;line-height:1.7">Questions? Reply to this email or contact '.e(setting('support_email','info@mitechwireless.com')).'.</p></td></tr></table></td></tr></table></body></html>';
    return [$title.' · '.$o['order_number'],$body];
}
function run_mail_queue(int $max=20): array {
    if(setting('smtp_host')===''||secret('smtp_password')==='')return ['sent'=>0,'failed'=>0,'configured'=>false];
    $sent=0;$failed=0;
    // Advisory lock prevents two cron workers sending the same queued message.
    if((int)query("SELECT GET_LOCK('mitech_mail_queue',0)")->fetchColumn()!==1)return ['sent'=>0,'failed'=>0,'busy'=>true];
    try{
        $jobs=all('SELECT * FROM email_queue WHERE status=? AND available_at<=UTC_TIMESTAMP() AND attempts<8 ORDER BY id LIMIT '.max(1,min(100,$max)),['pending']);
        foreach($jobs as $job){
            $o=one('SELECT * FROM orders WHERE id=?',[$job['order_id']]);
            try{$m=mailer();$m->addAddress($job['recipient']);[$m->Subject,$m->Body]=email_body($o,$job['kind']);$m->AltBody=html_entity_decode(strip_tags(str_replace(['</p>','</tr>'],"\n",$m->Body)));$m->MessageID='<mi-'.$job['id'].'@mitechwireless.com>';$m->send();query('UPDATE email_queue SET status=?,sent_at=UTC_TIMESTAMP(),attempts=attempts+1,last_error=? WHERE id=?',['sent','',$job['id']]);$sent++;}
            catch(Throwable $e){query('UPDATE email_queue SET attempts=attempts+1,last_error=?,available_at=DATE_ADD(UTC_TIMESTAMP(),INTERVAL 15 MINUTE) WHERE id=?',['SMTP delivery failed. Check server, authentication, and delivery logs.',$job['id']]);$failed++;}
        }
    }finally{query("SELECT RELEASE_LOCK('mitech_mail_queue')");}
    return ['sent'=>$sent,'failed'=>$failed,'configured'=>true];
}
