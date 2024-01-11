<?php

namespace App\Domain\Config;

/**
 * Interface for managing and retrieving configuration settings.
 */
interface ConfigManager
{
    /**
     * Key for retrieving the WebSocket address from the configuration.
     */
    public const KEY_WEBSOCKET_ADDRESS = 'websocket.baseUrl';

    /**
     * Key for retrieving the service time interval for Bike-related tasks from the configuration.
     */
    public const KEY_SERVICE_TIME_INTERVAL = 'bike_service_date_interval';

    /**
     * Gets the configuration value for the specified key.
     *
     * @param string $key The configuration key.
     * @return mixed The configuration value corresponding to the key.
     */
    public function getConfig(string $key): mixed;
}
