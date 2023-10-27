<?php

namespace App\Domain\Location;

class Location
{
    private string $longitude;
    private string $latitude;

    public function __construct(string $longitude, string $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function equals(mixed $location): bool
    {
        if(!($location instanceof $this))
        {
            return false;
        }

        if(!strcasecmp($this->getLongitude(), $location->getLongitude()) && !strcasecmp($this->getLatitude(), $location->latitude))
        {
            return true;
        }

        return false;
    }
}