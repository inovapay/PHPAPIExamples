<?php

# Load JWT Library
require_once('vendor/autoload.php');

# Set Auth Params
$api_key = 'API_KEY'; #Your api key
$api_secret = 'API_SECRET'; #Your api secret
# Gateway Transaction status API URL
# UAT: https://uat.inovapay.com/api/status
$url = 'https://uat.inovapay.com/api/status';
$client = new Client($url, $api_key, $api_secret);

echo "Find by reference: \n";
# Request Params
$params = ["reference" => 304421]; // or ["date" => "2019-05-17", "status" => "completed"];
$response = $client->post($params);
print_r($response);
echo "\n";

echo "Find by references: \n";
# Request Params
$params = ["reference" => [304421, 726887, 20332]]; // or ["date" => "2019-05-17", "status" => "completed"];
$response = $client->post($params);
print_r($response);
echo "\n";

echo "Find by status: \n";

$params = ["date" => "2019-05-29", "status" => "completed"]; // or ["date" => "2019-05-17", "status" => "completed"];
$response = $client->post($params);
print_r($response);
echo "\n";
