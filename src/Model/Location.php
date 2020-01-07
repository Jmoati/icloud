<?php

declare(strict_types=1);

namespace Jmoati\FindMyPhone\Model;

class Location
{
    public float $longitude;
    public float $latitude;
    public float $accuracy;

    public string $type;

    public bool $isOld;

    public function __construct(array $data)
    {
        $this->longitude = $data['longitude'];
        $this->latitude = $data['latitude'];
        $this->isOld = $data['isOld'];
        $this->type = $data['positionType'];
        $this->accuracy = $data['horizontalAccuracy'];
    }
}
