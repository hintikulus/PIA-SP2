<?php

namespace App\UI\Map;

class MarkerType
{
    private string $name;
    private ?string $iconUrl = null;
    private ?array $iconSize = null;
    private ?array $iconAnchor = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setIcon(string $iconUrl, ?array $iconSize = null, ?array $iconAnchor = null): self
    {
        $this->iconUrl = $iconUrl;
        $this->iconSize = $iconSize;
        $this->iconAnchor = $iconAnchor;
        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    /**
     * @return array<int>|null
     */
    public function getIconSize(): ?array
    {
        return $this->iconSize;
    }

    /**
     * @return array<int>|null
     */
    public function getIconAnchor(): ?array
    {
        return $this->iconAnchor;
    }
}