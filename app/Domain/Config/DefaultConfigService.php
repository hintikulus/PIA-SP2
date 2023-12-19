<?php

namespace App\Domain\Config;

class DefaultConfigService implements ConfigService
{
    private ConfigManager $configManager;

    public function __construct(
        ConfigManager $configManager,
    )
    {
        $this->configManager = $configManager;
    }

    public function getWebSocketAddress(): string
    {
        return $this->configManager->getConfig(ConfigManager::KEY_WEBSOCKET_ADDRESS);
    }

    public function getBikeServiceInterval(): \DateInterval
    {
        return \DateInterval::createFromDateString($this->configManager->getConfig(ConfigManager::KEY_SERVICE_TIME_INTERVAL));
    }
}