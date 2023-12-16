<?php

namespace App\Domain\Config;

interface ConfigService
{
    public function getWebSocketAddress(): string;
}