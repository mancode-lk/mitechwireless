<?php
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}
require dirname(__DIR__).'/includes/bootstrap.php';
echo json_encode(run_mail_queue()).PHP_EOL;
query('DELETE FROM rate_limits WHERE expires_at<?',[time()-86400]);
