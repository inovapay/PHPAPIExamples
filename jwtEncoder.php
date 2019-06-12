<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

$api_secret = 'API_SECRET'; #Your api secret

$params = [
    "user_id" => "896714",
    "transfers_id" => "102591",
    "reference" => "DINBO190604000013",
    "amount" => "52.00",
    "currency" => "BRL",
    "status" => "completed"
];

$jwt_encoded = JWT::encode($params, $api_secret, 'HS256');

echo "JWT Encoded: \n";

print_r($jwt_encoded);
echo "\n";
