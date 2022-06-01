<?php

declare(strict_types=1);

namespace Jmoati\FindMyPhone\Model;


final class Device
{
    public string $id;
    public string $name;
    public ?Location $location = null;
    public float $batteryLevel = 0;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];

        if (isset($data['location']) && false === $data['location']['isOld']) {
            $this->location = new Location($data['location']);
        }

        if ($data['batteryLevel'] > 0) {
            $this->batteryLevel = $data['batteryLevel'];
        }
    }
}
