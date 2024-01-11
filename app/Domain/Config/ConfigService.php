<?php

namespace App\Domain\Config;

/**
 * Interface for retrieving configuration settings.
 */
interface ConfigService
{
    /**
     * Gets the WebSocket address from the configuration.
     *
     * @return string The WebSocket address.
     */
    public function getWebSocketAddress(): string;

    /**
     * Gets the service interval for Bike-related tasks from the configuration.
     *
     * @return \DateInterval The Bike service interval as a DateInterval object.
     */
    public function getBikeServiceInterval(): \DateInterval;
}
