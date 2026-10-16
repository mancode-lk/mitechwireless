<?php
function request_settings_view(): void {
    echo '<section class="surface"><h2>Request checkout</h2><p>Accept recharge requests and save contact details while online payments are unavailable. Requests stay separate from paid orders until you connect and confirm payment.</p><form method="post">'.csrf().'<input type="hidden" name="action" value="request_mode">';
    checkbox('request_checkout_enabled','Accept recharge requests without online payment',request_checkout_enabled());
    echo '<p class="muted">Turn this off when your Stripe integration and plans are ready. The existing payment checkout, webhook and card fields will then be used.</p><button class="button secondary">Save request setting</button></form></section>';
}
function requests_view(): void {
    $search=is_string($_GET['q']??null)?mb_substr(trim($_GET['q']),0,254):'';
    $state=is_string($_GET['status']??null)?$_GET['status']:'';$where=['1=1'];$params=[];
    if($search!==''){$where[]='(reference LIKE ? OR customer_name LIKE ? OR email LIKE ? OR customer_phone LIKE ?)';$params=array_fill(0,4,'%'.$search.'%');}
    if($state==='complete')$where[]='completed_at IS NOT NULL';elseif($state==='started')$where[]='completed_at IS NULL';
    echo '<div class="notice"><strong>Awaiting payment.</strong> These requests include contact details and plan selections. Confirm payment before fulfillment; no card information is collected here.</div><form method="get" class="surface inline-filter"><div>';field('q','Search name, email, phone or reference',$search);echo '</div><div><label for="request-status">Progress</label><select name="status" id="request-status"><option value="">All submissions</option><option value="started" '.($state==='started'?'selected':'').'>Details saved</option><option value="complete" '.($state==='complete'?'selected':'').'>Submitted</option></select></div><button class="button primary">Search</button></form>';
    $where=implode(' AND ',$where);$count=(int)query('SELECT COUNT(*) FROM demo_submissions WHERE '.$where,$params)->fetchColumn();$page=max(1,min(100000,(int)($_GET['page']??1)));
    $rows=all('SELECT * FROM demo_submissions WHERE '.$where.' ORDER BY id DESC LIMIT 50 OFFSET '.(($page-1)*50),$params);
    echo '<section class="surface"><h2>'.$count.' checkout requests</h2><div class="table-wrap"><table><thead><tr><th>Reference / date</th><th>Customer</th><th>Phone number</th><th>Carrier / plan</th><th>Progress</th></tr></thead><tbody>';
    foreach($rows as $d)echo '<tr><td><a class="strong-link" href="/admin/request?id='.$d['id'].'">'.e($d['reference']).'</a><small>'.e(when($d['created_at'])).'</small></td><td>'.e($d['customer_name']).'<small>'.e($d['email']).'</small></td><td>'.e(format_phone($d['customer_phone'])).'<small>Recharge: '.e(format_phone($d['recharge_phone'])).'</small></td><td>'.e($d['carrier_name']).'<small>'.e($d['plan_name']).' · '.money($d['amount_cents']).'</small></td><td>'.status_badge($d['completed_at']?'submitted':'details_saved').'</td></tr>';
    if(!$rows)echo '<tr><td colspan="5">No matching checkout requests yet.</td></tr>';
    echo '</tbody></table></div>';paginate($page,$count);echo '</section>';
}
function request_view(): void {
    $d=one('SELECT * FROM demo_submissions WHERE id=?',[(int)($_GET['id']??0)]);
    if(!$d){http_response_code(404);echo '<p>Request not found.</p>';return;}
    echo '<a class="back-link" href="/admin/requests">← All checkout requests</a><section class="surface"><h2>'.e($d['reference']).'</h2><div class="notice">Payment has not been collected. No card information was received or saved.</div><dl class="order-details">';
    foreach(['Name'=>$d['customer_name'],'Email'=>$d['email'],'Phone number'=>format_phone($d['recharge_phone']),'Carrier'=>$d['carrier_name'],'Top-up'=>$d['plan_name'],'Plan price'=>money($d['amount_cents']),'Progress'=>$d['completed_at']?'Submitted':'Details saved — awaiting submission','Submitted'=>when($d['created_at']),'Submitted at'=>when($d['completed_at'])] as $key=>$value)echo '<div><dt>'.e($key).'</dt><dd>'.e($value).'</dd></div>';
    echo '</dl></section>';
}
