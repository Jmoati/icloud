<?php

declare(strict_types=1);

namespace Jmoati\FindMyPhone;

use Jmoati\FindMyPhone\Context\ClientContext;
use Jmoati\FindMyPhone\Model\Credential;
use Jmoati\FindMyPhone\Model\Device;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client
{
    private const HOST_DEFAULT = 'fmipmobile.icloud.com';

    public function __construct(
        private HttpClientInterface $client,
        private Credential $credential,
        private ?string $host = self::HOST_DEFAULT
    ) {
    }
    
    private function request(string $method, array $headers = []): array
    {
        $headers[] = 'Accept-Language: en-us';
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        $headers[] = 'X-Apple-Realm-Support: 1.0';
        $headers[] = 'X-Apple-Find-Api-Ver: 3.0';
        $headers[] = 'X-Apple-Authscheme: UserIdGuest';
        $headers['User-Agent'] = 'FindMyiPhone/376 CFNetwork/672.0.8 Darwin/14.0.0';

        $result = $this
            ->client
            ->request('POST',
                      sprintf("https://%s/fmipservice/device/%s/%s", $this->host, $this->credential->username, $method),
                      [
                          'verify_peer' => false,
                          'verify_host' => false,
                          'headers'     => $headers,
                          'json'        => [
                              'clientContext' => ClientContext::get(),
                          ],
                          'auth_basic'  => [
                              $this->credential->username,
                              $this->credential->password,
                          ],
                      ]
            );

        return json_decode($result->getContent(), true);
    }
    
    public function devices(): iterable
    {
        $devices = $this->request('initClient')['content'];

        return array_map(function(array $device) {
            return new Device($device);
        }, $devices);
    }
}
