<?php

declare(strict_types=1);

namespace Jmoati\FindMyPhone\Context;


final class ClientContext
{
    static public function get(): array
    {
        return [
            'appName'         => 'FindMyiPhone',
            'appVersion'      => '3.0',
            'buildVersion'    => '376',
            'clientTimestamp' => 0,
            'deviceUDID'      => null,
            'inactiveTime'    => 1,
            'osVersion'       => '7.0.3',
            'productType'     => 'iPhone6,1',
            'fmly'            => true,
//        'shouldLocate' => true,
//       'selectedDevice'=> "9/xkYLfL9WMuB+kkkxxaV2E9d3XKLI/iBGHq2IdrhE3+HCHi6aqEHOHYVNSUzmWV"
        ];
    }
}
