<?php

use Symfony\Component\HttpClient\HttpClient;

require __DIR__.'/secret.php';
require __DIR__.'/vendor/autoload.php';

const ICLOUD_URL = 'https://fmipmobile.icloud.com';

$client = HttpClient::create();

$response = $client->request('POST', sprintf('%s/fmipservice/device/%s/initClient', ICLOUD_URL, $username), [
    'auth_basic' => [$username, $password],
    'verify_peer' => false,
    'headers' => [
        'User-Agent' => 'FindMyiPhone/472.1 CFNetwork/711.1.12 Darwin/14.0.0',
        'X-Apple-Realm-Support' => '1.0',
        'X-Apple-Find-API-Ver' => '3.0',
        'X-Apple-AuthScheme' => 'UserIdGuest',
     ]
]);

dd(json_decode($response->getContent()));