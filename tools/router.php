<?php
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$root = dirname(__DIR__);
if (preg_match('~^/assets/[a-zA-Z0-9/_-]+(?:\.min)?\.(css|js|svg|png|webp|ico)$~D', $path) && is_file($root.$path)) return false;
if (preg_match('~^/(config|includes|sql|tools|tests|research|storage|vendor|node_modules)(/|$)|/\.|\.(json|lock|md)$~i', $path)) {http_response_code(403);exit('Forbidden');}
if (str_starts_with($path, '/admin')) require $root.'/admin/index.php';
else require $root.'/index.php';
