<?php

use Symfony\Component\HttpClient\HttpClient;

require __DIR__ . '/secret.php';
require __DIR__ . '/vendor/autoload.php';

class FindMyiPhone {
    private $username;
    private $password;
    private $host = 'fmipmobile.icloud.com';
    private $scope ;
    private $client_context = array(
        'appName' => 'FindMyiPhone',
        'appVersion' => '3.0',
        'buildVersion' => '376',
        'clientTimestamp' => 0,
        'deviceUDID' => null,
        'inactiveTime' => 1,
        'osVersion' => '7.0.3',
        'productType' => 'iPhone6,1',
        'fmly'=> true,
//        'shouldLocate' => true,
//       'selectedDevice'=> "9/xkYLfL9WMuB+kkkxxaV2E9d3XKLI/iBGHq2IdrhE3+HCHi6aqEHOHYVNSUzmWV"
    );
    private $server_context = array(
        'callbackIntervalInMS' => 10000,
        'classicUser' => false,
        'clientId' => null,
        'cloudUser' => true,
        'deviceLoadStatus' => '200',
        'enableMapStats' => false,
        'isHSA' => false,
        'lastSessionExtensionTime' => null,
        'macCount' => 0,
        'maxDeviceLoadTime' => 60000,
        'maxLocatingTime' => 90000,
        'preferredLanguage' => 'en-us',
        'prefsUpdateTime' => 0,
        'sessionLifespan' => 900000,
        'timezone' => null,
        'trackInfoCacheDurationInSecs' => 86400,
        'validRegion' => true
    );
    /**
     * Constructor
     * Checks requred extensions, sets username/password and gets url host for the user.
     * @param $username - iCloud Apple ID
     * @param $password - iCloud Password
     */
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;

        $this->init_client();
    }

    private function init_client() {
        $post_data = [
            'clientContext' => $this->client_context,
        ];

        array_walk($this->make_request('initClient', $post_data)['content'], function($device) {
            dump($device["name"], $device['id']);
        });
    }

    /**
     * Make request to the Find My iPhone server.
     * @param $method - the method
     * @param $post_data - the POST data
     * @param $return_headers - also return headers when true
     * @param $headers - optional headers to send
     * @return HTTP response
     */
    private function make_request($method, $post_data, $return_headers = false, $headers = array()) {
        if(!isset($this->scope)) $this->scope = $this->username;

        array_push($headers, 'Accept-Language: en-us');
        array_push($headers, 'Content-Type: application/json; charset=utf-8');
        array_push($headers, 'X-Apple-Realm-Support: 1.0');
        array_push($headers, 'X-Apple-Find-Api-Ver: 3.0');
        array_push($headers, 'X-Apple-Authscheme: UserIdGuest');
        $headers['User-Agent'] = 'FindMyiPhone/376 CFNetwork/672.0.8 Darwin/14.0.0';

        $client = HttpClient::create();

        $http_result = $client->request('POST',
            sprintf("https://%s/fmipservice/device/%s/%s", $this->host, $this->scope, $method),
            [
                'headers' => $headers,
                'json' => $post_data,
                'auth_basic' => [
                    $this->username,
                    $this->password,
                    ],
            ]
        );

        return json_decode($http_result->getContent(), true);
    }
}


$client = new FindMyiPhone($username, $password);
