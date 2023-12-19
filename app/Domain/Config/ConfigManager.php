<?php

namespace App\Domain\Config;

interface ConfigManager
{
    public const KEY_WEBSOCKET_ADDRESS = 'websocket.baseUrl';
    public const KEY_SERVICE_TIME_INTERVAL = 'bike_service_date_interval';
    public function getConfig(string $key): mixed;
}