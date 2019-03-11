<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

# Gateway deposit API URL
# UAT: https://uat.inovapay.com/deposit/deposit/api_key/token/

# Set Auth Params
$api_user = '8018580'; #Your api user
$api_secret = 'e42573f5782eb327db7e24fb6f85977ac811c11c'; #Your api key
# Valid period for this request (optional)
$issued_at = time() - 5;        # timestamp minus 5 seconds for an eventual server time difference
$expire = $issued_at + 60;    # 60 seconds after $issued_at
# Request Params
$params = array(
    'iat' => $issued_at,
    'exp' => $expire,
    'data' => array(
        'name' => 'John Doe', # User's name
        'email' => 'john.doe@hotmail.com', # User’s email
        'cpf' => '1321311333', # User’s cpf
        'paymentMethod' => 'caixa', # It will be the defined deposit method:boleto, banco-do-brasil, bradesco, caixa, itau, santander
        'amount' => '20', # Deposit amount
        'currency' => 'brl', # Options brl (Real) or usd (Dollar)
        'reference' => '123456789', # Deposit reference code
        'merchant_user' => 'Admin', # Identifies the user on your system
    )
);
# Generate the encoded token with HS256
$jwt_encoded = JWT::encode($params, $api_secret, 'HS256');
# Format the POST body data. An associative array.
$body = array('jwt' => $jwt_encoded);
# Encode in JSON
$body_json = json_encode($body);

$url = 'https://uat.inovapay.com/direct/deposit/' . $api_user . '/' . $body_json .'/';

# Set the POST Headers
$headers = array(
    'x-api-key: ' . $api_user,
    'Content-Type: application/json',
    'Accept-Language: pt-BR', # Language for error message, available: pt-BR en-US
);

# GET request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

# Print the GET response in screen
print_r($response);
