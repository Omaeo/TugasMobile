<?php
require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

$key = "contoh_secret";
$payload = [
    "user_id" => 1,
    "username" => "tester",
    "exp" => time() + 3600
];

$jwt = JWT::encode($payload, $key, 'HS256');
echo "Token: " . $jwt;
    