<?php

namespace App\Domain\Config;

class DefaultConfigManager implements ConfigManager
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig(string $key): mixed
    {
        return $this->config[$key];
    }
}