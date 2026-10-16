<?php
if(PHP_SAPI!=='cli')exit(1);
require dirname(__DIR__).'/includes/bootstrap.php';
if(!in_array(query('SELECT DATABASE()')->fetchColumn(),['mancode_mitopup','mancode_mitopupqa'],true))throw new RuntimeException('Unexpected database');
db()->exec(file_get_contents(ROOT.'/sql/selected-carriers.sql'));
echo "Selected-carrier catalog applied; existing order and contact records preserved.\n";
