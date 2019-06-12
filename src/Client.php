<?php

# Load JWT Library
require_once('vendor/autoload.php');

use \Firebase\JWT\JWT;

class Client
{
    protected $url;
    protected $api_key;
    protected $api_secret;
    protected $language;

    public function __construct(string $url, string $api_key, string $api_secret, string $language = "pt-BR")
    {
        $this->url        = $url;
        $this->api_key    = $api_key;
        $this->api_secret = $api_secret;
        $this->language   = $language;
    }

    public function post(array $params)
    {
        # Generate the encoded token with HS256
        $jwt_encoded = JWT::encode($params, $this->api_secret, 'HS256');

        # Format the POST body data to json. An associative array.
        $body    = json_encode(['jwt' => $jwt_encoded]);

        # Set the POST Headers
        $headers = [
            'x-api-key: ' . $this->api_key,
            'Content-Type: application/json',
            'Accept-Language: ' . $this->language, # Language for error message, available: pt-BR en-US
        ];

        # POST the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $content = json_decode($response);

        if (!empty($content->jwt)) {
            return JWT::decode($content->jwt, $this->api_secret, ['HS256']);
        }

        # Print the POST response in screen
        return $response;
    }

    public function put(array $params)
    {
        # Generate the encoded token with HS256
        $jwt_encoded = JWT::encode($params, $this->api_secret, 'HS256');

        # Format the POST body data to json. An associative array.
        $body    = json_encode(['jwt' => $jwt_encoded]);

        # Set the POST Headers
        $headers = [
            'x-api-key: ' . $this->api_key,
            'Content-Type: application/json',
            'Accept-Language: ' . $this->language, # Language for error message, available: pt-BR en-US
        ];

        # POST the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $content = json_decode($response);

        if (!empty($content->jwt)) {
            return JWT::decode($content->jwt, $this->api_secret, ['HS256']);
        }

        # Print the POST response in screen
        return $response;
    }
}