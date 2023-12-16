<?php

namespace App\Domain\Location;

class Location
{
    private string $longitude;
    private string $latitude;

    public function __construct(string|float $latitude, string|float $longitude)
    {
        $this->latitude = strval($latitude);
        $this->longitude = strval($longitude);
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

    public function distance(Location $location): float
    {
        return self::haversineDistance($this, $location);
    }

    public static function haversineDistance(Location $location1, Location $location2): float
    {
        $earthRadius = 6371000; // Poloměr Země v metrech

        // Převod zeměpisných šířek a délek na radiány
        $lat1 = deg2rad($location1->latitude);
        $lon1 = deg2rad($location1->longitude);
        $lat2 = deg2rad($location2->latitude);
        $lon2 = deg2rad($location2->longitude);

        // Haversinův vzorec
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
