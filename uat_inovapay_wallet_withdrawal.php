<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

# Wallet withdrawal API URL
# UAT: https://uat.inovapay.com/api/withdrawal
$url = 'https://uat.inovapay.com/api/withdrawal';

# Set Auth Params
$api_key = '8018580'; #Your api key
$api_secret = 'e42573f5782eb327db7e24fb6f85977ac811c11c'; #Your api secret
# Valid period for this request (optional)
$issued_at = time() - 5;        # timestamp minus 5 seconds for an eventual server time difference
$expire = $issued_at + 60;    # 60 seconds after $issued_at
# Request Params
$params = array(
    'iat' => $issued_at,
    'exp' => $expire,
    'data' => array(
        'reference' => rand(10000, 100000), # Current transaction id, set by you !!!
        'user_id' => '123456', # User’s ID on Inovapay
        'user_login' => 'admin123', # User’s Login on Merchant
        'user_name' => 'Admin', # User’s name
        'user_secure_id' => '123456789', # User’s Secure ID on
        'amount' => '10', # Transaction Value. Ex. (100.50)
        'currency' => 'brl', # “usd” or “brl”
        'action' => 'create', # “validate” or “create”
    )
);
# Generate the encoded token with HS256
$jwt_encoded = JWT::encode($params, $api_secret, 'HS256');
# Format the POST body data. An associative array.
$body = array('jwt' => $jwt_encoded);
# Encode in JSON
$body_json = json_encode($body);

# Set the POST Headers
$headers = array(
    'x-api-key: ' . $api_key,
    'Content-Type: application/json',
    'Accept-Language: pt-BR', # Language for error message, available: pt-BR en-US
);

# POST the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $body_json);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

# Print the POST response in screen
print_r($response);
