<?php

# Load JWT Library
require_once('vendor/autoload.php');

# Set Auth Params
$api_key = 'API_KEY'; #Your api key
$api_secret = 'API_SECRET'; #Your api secret
$url = 'https://uat.inovapay.com/inovapin/voucher/validate';

$client = new Client($url, "2301615", "e176ae5ab5bc985741db24552f5e03f5b0257931");

echo "Pin validate: \n";
$issued_at = time() - 5;      # timestamp minus 5 seconds for an eventual server time difference
$expire = $issued_at + 60;    # 60 seconds after $issued_at
# Request Params
$params = [
    'iat' => $issued_at,
    'exp' => $expire,
    'data' => [
        'pin' => '9614251297434570', //'4121972612524358', # Given pin 16 digit number
        'terminalID' => '454777', # Merchant´s terminal id, set by you
        'reference' => rand(10000, 100000), # Current transaction id, set by you
    ]
];

$response = $client->post($params);
print_r($response);
echo "\n";
