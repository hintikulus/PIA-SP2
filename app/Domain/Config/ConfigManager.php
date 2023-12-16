<?php

namespace App\Domain\Config;

interface ConfigManager
{
    public const KEY_WEBSOCKET_ADDRESS = 'websocket.baseUrl';
    public function getConfig(string $key): mixed;
}