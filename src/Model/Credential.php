<?php

declare(strict_types=1);

namespace Jmoati\FindMyPhone\Model;

final class Credential
{
    public function __construct(
        public string $username = '',
        public string $password = ''
    ) {
    }
}
