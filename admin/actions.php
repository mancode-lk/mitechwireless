<?php
function upload_logo(string $field): string {
    $f=$_FILES[$field]??null;if(!$f||$f['error']===UPLOAD_ERR_NO_FILE)return '';
    if($f['error']!==UPLOAD_ERR_OK||$f['size']>2*1024*1024)throw new InvalidArgumentException('Upload a PNG, JPEG, or WebP logo smaller than 2 MB.');
    $type=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);$info=@getimagesize($f['tmp_name']);
    if(!in_array($type,['image/png','image/jpeg','image/webp'],true)||!$info||$info[0]>3000||$info[1]>3000)throw new InvalidArgumentException('Choose a valid logo image, at most 3000 × 3000 pixels.');
    // Re-encoding removes metadata and rejects executable/polyglot file content.
    $image=@imagecreatefromstring(file_get_contents($f['tmp_name']));if(!$image)throw new InvalidArgumentException('The image could not be read.');
    $dir=ROOT.'/assets/uploads';if(!is_dir($dir))mkdir($dir,0755,true);$name=bin2hex(random_bytes(16)).'.png';imagesavealpha($image,true);imagepng($image,$dir.'/'.$name);imagedestroy($image);return '/assets/uploads/'.$name;
}
function checked(string $key): int {return isset($_POST[$key])?1:0;}
function color_value(string $key,string $fallback): string {$v=post($key,7)?:$fallback;if(!preg_match('/^#[0-9a-f]{6}$/i',$v))throw new InvalidArgumentException('Choose a valid color.');return $v;}
function contrast_white(string $hex): float {$values=[];foreach(str_split(substr($hex,1),2) as $h){$c=hexdec($h)/255;$values[]=$c<=.04045?$c/12.92:(($c+.055)/1.055)**2.4;}return 1.05/(.2126*$values[0]+.7152*$values[1]+.0722*$values[2]+.05);}
function admin_action(array $admin): void {
    csrf_check();$action=post('action',40,true);
    if($action==='logout'){$_SESSION=[];session_regenerate_id(true);redirect('/admin/login');}
    if($admin['must_change_password']&&$action!=='password')throw new InvalidArgumentException('Change your temporary password first.');
    if($action==='request_mode'){
        save_setting('request_checkout_enabled',(string)checked('request_checkout_enabled'));
        flash(checked('request_checkout_enabled')?'Request checkout enabled. Requests are saved awaiting payment.':'Request checkout disabled. Stripe checkout settings now apply.');
        redirect('/admin/settings');
    }
    if($action==='password'){
        limit('password',10,900);$old=post('current_password',1024,true);$pw=post('new_password',1024,true);$repeat=post('confirm_password',1024,true);
        $a=one('SELECT * FROM admins WHERE id=?',[$admin['id']]);if(!password_verify($old,$a['password_hash']))throw new InvalidArgumentException('The current password is incorrect.');
        if(strlen($pw)<14||$pw!==$repeat||$pw===$old)throw new InvalidArgumentException('Use a new password of at least 14 characters and make both new-password fields match.');
        query('UPDATE admins SET password_hash=?,must_change_password=0,session_version=session_version+1 WHERE id=?',[password_hash($pw,PASSWORD_DEFAULT),$admin['id']]);
        session_regenerate_id(true);$_SESSION['csrf']=bin2hex(random_bytes(32));$_SESSION['admin_version']=(int)$a['session_version']+1;flash('Password changed. Other admin sessions were signed out.');redirect('/admin');
    }
    if($action==='carrier_save'){
        $id=(int)post('id',20);$name=post('name',100,true);$slug=post('slug',100,true);
        if(!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D',$slug))throw new InvalidArgumentException('Use lowercase words separated by hyphens for the slug.');
        $source=post('source_url',500);if($source!==''&&!filter_var($source,FILTER_VALIDATE_URL))throw new InvalidArgumentException('Enter a valid source URL.');
        if(one('SELECT id FROM carriers WHERE slug=? AND id<>?',[$slug,$id]))throw new InvalidArgumentException('That carrier slug is already used.');
        $old=$id?one('SELECT * FROM carriers WHERE id=?',[$id]):null;if($id&&!$old)throw new InvalidArgumentException('Carrier not found.');
        $logo=upload_logo('logo')?:($old['logo']??'');$values=[$name,$slug,$logo,color_value('color','#222222'),post('description',3000),post('number_hint',255),$source,checked('active'),integer('sort_order',0,9999)];
        if($id)query('UPDATE carriers SET name=?,slug=?,logo=?,color=?,description=?,number_hint=?,source_url=?,active=?,sort_order=? WHERE id=?',[...$values,$id]);else query('INSERT INTO carriers (name,slug,logo,color,description,number_hint,source_url,active,sort_order) VALUES (?,?,?,?,?,?,?,?,?)',$values);
        flash('Carrier saved.');redirect('/admin/carriers');
    }
    if($action==='plan_save'){
        $id=(int)post('id',20);$carrier=integer('carrier_id',1,PHP_INT_MAX);if(!one('SELECT id FROM carriers WHERE id=?',[$carrier]))throw new InvalidArgumentException('Choose a carrier.');
        if($id&&!one('SELECT id FROM plans WHERE id=?',[$id]))throw new InvalidArgumentException('Plan not found.');
        $values=[$carrier,post('name',150,true),price(post('price',10,true)),post('data_allowance',100),post('talk',100),post('texts',100),integer('validity_days',0,3650),post('description',3000),checked('popular'),checked('active'),checked('verify_pricing'),integer('sort_order',0,9999)];
        if($id)query('UPDATE plans SET carrier_id=?,name=?,price_cents=?,data_allowance=?,talk=?,texts=?,validity_days=?,description=?,popular=?,active=?,verify_pricing=?,sort_order=? WHERE id=?',[...$values,$id]);else query('INSERT INTO plans (carrier_id,name,price_cents,data_allowance,talk,texts,validity_days,description,popular,active,verify_pricing,sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',$values);
        flash('Plan saved. Unverified plans cannot be purchased.');redirect('/admin/plans?carrier='.$carrier);
    }
    if(in_array($action,['carrier_delete','plan_delete','carrier_toggle','plan_toggle'],true)){
        $carrier=str_starts_with($action,'carrier');$table=$carrier?'carriers':'plans';$id=integer('id',1,PHP_INT_MAX);
        if(str_ends_with($action,'toggle'))query('UPDATE '.$table.' SET active=1-active WHERE id=?',[$id]);
        else{
            if(one('SELECT id FROM orders WHERE '.($carrier?'carrier_id':'plan_id').'=? LIMIT 1',[$id])||($carrier&&one('SELECT id FROM plans WHERE carrier_id=? LIMIT 1',[$id])))throw new InvalidArgumentException('This record is in use. Disable it instead to keep order history intact.');
            query('DELETE FROM '.$table.' WHERE id=?',[$id]);
        }flash('Catalog updated.');redirect('/admin/'.$table);
    }
    if($action==='order_update'){
        $id=integer('id',1,PHP_INT_MAX);$status=post('recharge_status',24,true);$notes=post('notes',10000);
        if(!in_array($status,['processing','recharged','failed'],true))throw new InvalidArgumentException('Choose a valid recharge status.');
        db()->beginTransaction();try{
            $o=one('SELECT * FROM orders WHERE id=? FOR UPDATE',[$id]);if(!$o||$o['payment_status']!=='paid')throw new InvalidArgumentException('Only fully paid, non-refunded orders can enter fulfillment.');
            query('UPDATE orders SET recharge_status=?,notes=? WHERE id=?',[$status,$notes,$id]);
            if($status!==$o['recharge_status'])history($id,$status,'Recharge marked '.str_replace('_',' ',$status).'.',(int)$admin['id']);
            if($notes!==$o['notes'])history($id,'note_updated','Internal notes updated.',(int)$admin['id']);
            if($status==='recharged')queue_email($id,'completed',$o['email']);db()->commit();
        }catch(Throwable $e){if(db()->inTransaction())db()->rollBack();throw $e;}
        flash('Order updated. Completion email is queued when applicable.');redirect('/admin/order?id='.$id);
    }
    if($action==='refund'){
        $id=integer('id',1,PHP_INT_MAX);$a=one('SELECT password_hash FROM admins WHERE id=?',[$admin['id']]);
        if(!password_verify(post('password',1024,true),$a['password_hash']))throw new InvalidArgumentException('Confirm your admin password to issue a refund.');
        limit('refund',5,900);$o=one('SELECT * FROM orders WHERE id=?',[$id]);if(!$o||!in_array($o['payment_status'],['paid','partially_refunded'],true)||!$o['payment_id'])throw new InvalidArgumentException('This order cannot be refunded.');
        $refund=stripe_client($o['stripe_mode'])->refunds->create(['payment_intent'=>$o['payment_id']],['idempotency_key'=>'mitech-full-refund-'.$o['order_number']]);
        query('UPDATE orders SET refund_id=? WHERE id=?',[$refund->id,$id]);history($id,'refund_requested','Full remaining refund submitted to Stripe.',(int)$admin['id']);reconcile_payment($o['payment_id'],$o['stripe_mode']);
        flash('Refund submitted. Final status follows Stripe confirmation.');redirect('/admin/order?id='.$id);
    }
    if($action==='settings'){
        $mode=post('stripe_mode',4);if(!in_array($mode,['test','live'],true))throw new InvalidArgumentException('Choose Test or Live.');
        $values=[];foreach(['site_name'=>100,'hero_title'=>90,'hero_accent'=>90,'hero_description'=>400,'support_phone'=>40,'support_hours'=>200,'business_address'=>500,'smtp_host'=>255,'smtp_username'=>254] as $k=>$max)$values[$k]=post($k,$max,in_array($k,['site_name','hero_title','hero_accent'],true));
        $values['support_email']=valid_email(post('support_email',254,true));$values['sender_email']=valid_email(post('sender_email',254,true));
        $values['smtp_port']=(string)integer('smtp_port',1,65535);$values['smtp_security']=post('smtp_security',3);if(!in_array($values['smtp_security'],['tls','ssl'],true))throw new InvalidArgumentException('Use TLS or SSL for SMTP.');
        if($values['smtp_host']!==''&&!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9.-]{0,253}$/D',$values['smtp_host']))throw new InvalidArgumentException('Enter an SMTP hostname, without a protocol or path.');
        foreach(['color_primary'=>'#e21e2c','color_secondary'=>'#17191d','color_accent'=>'#fff1f2'] as $k=>$fallback)$values[$k]=color_value($k,$fallback);
        if(contrast_white($values['color_primary'])<4.5||contrast_white($values['color_secondary'])<4.5)throw new InvalidArgumentException('Primary and secondary colors must be dark enough for readable white text (4.5:1 contrast).');
        $values['stripe_mode']=$mode;$values['checkout_enabled']=(string)checked('checkout_enabled');
        foreach(['test','live'] as $m){$key=post('stripe_'.$m.'_publishable',255);if($key!==''&&!str_starts_with($key,'pk_'.$m.'_'))throw new InvalidArgumentException('The '.$m.' publishable key has the wrong prefix.');$values['stripe_'.$m.'_publishable']=$key;
            foreach(['secret'=>'sk_'.$m.'_','webhook'=>'whsec_'] as $suffix=>$prefix){$field='stripe_'.$m.'_'.$suffix;$v=post($field,255);if($v!==''){if(!str_starts_with($v,$prefix))throw new InvalidArgumentException('Check the '.$m.' '.$suffix.' key.');$values[$field]=seal($v);}}
        }
        if(($v=post('smtp_password',1024))!=='')$values['smtp_password']=seal($v);
        $faqs=[];$questions=$_POST['faq_question']??[];$answers=$_POST['faq_answer']??[];
        if(!is_array($questions)||!is_array($answers)||count($questions)>40)throw new InvalidArgumentException('Invalid FAQ data.');
        foreach($questions as $i=>$q){$ans=$answers[$i]??'';if(!is_string($q)||!is_string($ans)||mb_strlen($q)>250||mb_strlen($ans)>3000)throw new InvalidArgumentException('Keep FAQ questions under 250 characters and answers under 3000.');if(trim($q)===''&&trim($ans)==='')continue;if(trim($q)===''||trim($ans)==='')throw new InvalidArgumentException('Each FAQ needs both a question and answer.');$faqs[]=['question'=>trim($q),'answer'=>trim($ans)];}$values['faqs']=json_encode($faqs);
        $links=json_decode(post('footer_links',5000)?:'[]',true);if(!is_array($links)||count($links)>10)throw new InvalidArgumentException('Footer links must be a JSON array with up to 10 entries.');
        foreach($links as $link){if(!is_array($link)||!is_string($link['label']??null)||!is_string($link['url']??null)||strlen($link['label'])>80||!preg_match('~^(?:https://[^\s]+|/(?!/)[a-zA-Z0-9/_-]*)$~D',$link['url']))throw new InvalidArgumentException('Footer links need label and safe https:// or /local-path URL fields.');}$values['footer_links']=json_encode($links);
        $logo=upload_logo('site_logo');if($logo)$values['site_logo']=$logo;
        if($values['checkout_enabled']==='1'){
            foreach(['stripe_'.$mode.'_publishable','stripe_'.$mode.'_secret','stripe_'.$mode.'_webhook','smtp_host','smtp_username','smtp_password'] as $required){if(($values[$required]??setting($required))==='')throw new InvalidArgumentException('Configure Stripe keys, webhook signing secret, and SMTP before enabling checkout.');}
        }
        db()->beginTransaction();try{foreach($values as $key=>$value)save_setting($key,$value);db()->commit();}catch(Throwable $e){db()->rollBack();throw $e;}
        flash('Settings saved. Public changes are visible immediately.');redirect('/admin/settings');
    }
    if($action==='mail_retry'){query('UPDATE email_queue SET attempts=0,available_at=UTC_TIMESTAMP(),last_error=? WHERE id=? AND status<>?',['',integer('id',1,PHP_INT_MAX),'sent']);flash('Message queued for retry.');redirect('/admin/emails');}
    if($action==='mail_run'){$result=run_mail_queue();flash('Email queue: '.$result['sent'].' sent, '.$result['failed'].' failed.');redirect('/admin/emails');}
    if($action==='smtp_test'){
        limit('smtp-test',3,900);$m=mailer();$m->addAddress(valid_email(post('test_email',254,true)));$m->Subject='MI Tech Wireless · SMTP connection test';$m->Body='<h1>SMTP connection successful</h1><p>This test was requested from the MI Tech Wireless admin panel.</p>';$m->AltBody='SMTP connection successful. Requested from the MI Tech Wireless admin panel.';$m->send();flash('The test message was accepted by the SMTP server. Check the receiving inbox and spam folder.');redirect('/admin/settings');
    }
    throw new InvalidArgumentException('Unknown action.');
}
