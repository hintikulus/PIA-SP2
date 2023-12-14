<?php

namespace App\UI\Map;

use App\Domain\Location\Location;
use App\Model\Utils\Html;

class Marker
{
    private Location $location;
    private ?string $label;
    private ?string $markerType;
    private ?Html $popup = null;
    private ?string $type;

    public function __construct(Location $location, ?string $label, ?string $markerType = null, string $type = null)
    {
        $this->location = $location;
        $this->label = $label;
        $this->markerType = $markerType;
        $this->type = $type;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getMarkerType(): ?string
    {
        return $this->markerType;
    }

    public function setMarkerType(string $markerType): void
    {
        $this->markerType = $markerType;
    }

    public function setPopup(Html $html): self
    {
        $this->popup = $html;
        return $this;
    }

    public function getPopup(): ?Html
    {
        return $this->popup;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
