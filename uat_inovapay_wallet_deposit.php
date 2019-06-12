<?php

# Load JWT Library
require_once('vendor/autoload.php');

# Set Auth Params
$api_key = 'API_KEY'; #Your api key
$api_secret = 'API_SECRET'; #Your api secret
$url = 'https://uat.inovapay.com/api/deposit';
$client = new Client($url, $api_key, $api_secret);

echo "Create a deposit: \n";
$issued_at = time() - 5;      # timestamp minus 5 seconds for an eventual server time difference
$expire = $issued_at + 60;    # 60 seconds after $issued_at
# Request Params
$params = [
    'iat' => $issued_at,
    'exp' => $expire,
    'data' => [
        'reference' => rand(10000, 100000), # Current transaction id, set by you
        'user_id' => '12777', # User’s ID on Inovapay
        'user_login' => 'ezequiel', # User’s Login on Merchant
        'user_name' => 'Ezequiel', # User’s name
        'user_secure_id' => '517023', # User’s Secure ID on
        'amount' => '50', # Transaction Value. Ex. (100.50)
        'currency' => 'BRL', # “USD” or “BRL”
    ]
];

$response = $client->post($params);
print_r($response);
echo "\n";
