<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

# Pin transaction query API URL
# UAT: https://uat.inovapay.com/inovapin/trans/transNo
$url = 'https://uat.inovapay.com/inovapin/trans/transNo';

# Set Auth Params
$api_user = '9396735'; #Your api user
$api_secret = 'ee0123a639e3fecc6fb7b83a4318186b6950b172'; #Your api key
# Valid period for this request (optional)
$issued_at = time() - 5;        # timestamp minus 5 seconds for an eventual server time difference
$expire = $issued_at + 60;    # 60 seconds after $issued_at
# Request Params
$params = array(
    'iat' => $issued_at,
    'exp' => $expire,
    'data' => array(
        'transNo' => '6546546', # Inovapay past transaction number you whish to inquire
        'terminalID' => '454096', # Merchant´s terminal id, set by you !!!
        'currentTranID' => rand(10000, 100000), # Current transaction id, set by you !!!
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
    'x-api-key: ' . $api_user,
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
