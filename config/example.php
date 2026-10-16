<?php
return [
    'dsn' => 'mysql:host=localhost;dbname=mitechwireless;charset=utf8mb4',
    'db_user' => 'mitechwireless',
    'db_password' => '',
    'app_key' => '', // Generate once: bin2hex(random_bytes(32)). Keep this key across deployments.
    'base_url' => 'https://mitechwireless.com',
    'environment' => 'production',
    'timezone' => 'America/New_York',
];
