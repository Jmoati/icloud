<?php

require __DIR__ . '/secret.php';
require __DIR__ . '/vendor/autoload.php';

use Jmoati\FindMyPhone\Client;
use Jmoati\FindMyPhone\Model\Credential;
use Symfony\Component\HttpClient\HttpClient;

$client = new Client(
    HttpClient::create(),
    new Credential($username, $password)
);

dd($client->devices());
