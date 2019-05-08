<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

# Gateway deposit API URL
# UAT: https://uat.inovapay.com/direct/deposit/api_key/token/

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

$url = 'https://uat.inovapay.com/direct/deposit/' . $api_key . '/' . $jwt_encoded .'/';

# Set the POST Headers
$headers = array(
    'x-api-key: ' . $api_key,
    'Accept-Language: pt-BR', # Language for error message, available: pt-BR en-US
);

header('x-api-key: ' . $api_key);
header('Accept-Language: pt-BR');
header('Location: ' . $url);
print_r('redirecting');
exit;
?>
