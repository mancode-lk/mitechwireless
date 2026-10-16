<?php
if(PHP_SAPI!=='cli')exit(1);
require dirname(__DIR__).'/includes/bootstrap.php';
if(!in_array(query('SELECT DATABASE()')->fetchColumn(),['mancode_mitopup','mancode_mitopupqa'],true))throw new RuntimeException('Unexpected database');
db()->exec(file_get_contents(ROOT.'/sql/demo.sql'));
if(in_array('--enable',$argv,true))save_setting('demo_checkout_enabled','1');
echo "Demo storage ready. Existing orders and catalog unchanged.\n";
