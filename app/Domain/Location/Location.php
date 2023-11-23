<?php

namespace App\Domain\Location;

class Location
{
    private string $longitude;
    private string $latitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLatitudeFloat(): float
    {
        return floatval($this->latitude);
    }

    public function getLongitudeFloat(): float
    {
        return floatval($this->longitude);
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

    public function toString(): string
    {
        return "{$this->latitude} N, {$this->longitude} E";
    }
}