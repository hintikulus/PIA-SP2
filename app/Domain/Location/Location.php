<?php

namespace App\Domain\Location;

/**
 * Represents a geographic location with latitude and longitude coordinates.
 */
class Location
{
    private string $longitude;
    private string $latitude;

    /**
     * Constructor to initialize the Location with latitude and longitude.
     *
     * @param string|float $latitude The latitude coordinate.
     * @param string|float $longitude The longitude coordinate.
     */
    public function __construct(string|float $latitude, string|float $longitude)
    {
        $this->latitude = strval($latitude);
        $this->longitude = strval($longitude);
    }

    /**
     * Gets the longitude coordinate as a string.
     *
     * @return string The longitude coordinate.
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * Gets the latitude coordinate as a string.
     *
     * @return string The latitude coordinate.
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * Gets the latitude coordinate as a float.
     *
     * @return float The latitude coordinate.
     */
    public function getLatitudeFloat(): float
    {
        return floatval($this->latitude);
    }

    /**
     * Gets the longitude coordinate as a float.
     *
     * @return float The longitude coordinate.
     */
    public function getLongitudeFloat(): float
    {
        return floatval($this->longitude);
    }

    /**
     * Checks if two locations are equal.
     *
     * @param mixed $location Another location to compare.
     * @return bool True if the locations are equal, false otherwise.
     */
    public function equals(mixed $location): bool
    {
        // Check if the given object is an instance of Location
        if (!($location instanceof $this)) {
            return false;
        }

        // Compare latitude and longitude case-insensitively
        if (!strcasecmp($this->getLongitude(), $location->getLongitude()) && !strcasecmp($this->getLatitude(), $location->latitude)) {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation of the location.
     *
     * @return string The string representation of the location.
     */
    public function toString(): string
    {
        return "{$this->latitude} N, {$this->longitude} E";
    }

    /**
     * Calculates the distance between two locations using the Haversine formula.
     *
     * @param Location $location Another location to calculate the distance to.
     * @return float The distance between the two locations in meters.
     */
    public function distance(Location $location): float
    {
        return self::haversineDistance($this, $location);
    }

    /**
     * Calculates the Haversine distance between two locations.
     *
     * @param Location $location1 The first location.
     * @param Location $location2 The second location.
     * @return float The distance between the two locations in meters.
     */
    public static function haversineDistance(Location $location1, Location $location2): float
    {
        $earthRadius = 6371000; // Earth radius in meters

        // Convert latitude and longitude to radians
        $lat1 = deg2rad($location1->latitude);
        $lon1 = deg2rad($location1->longitude);
        $lat2 = deg2rad($location2->latitude);
        $lon2 = deg2rad($location2->longitude);

        // Haversine formula
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Returns a string representation of the Location.
     *
     * @return string The string representation of the Location.
     */
    public function __toString(): string
    {
        return "Location{latitude='{$this->latitude}', longitude='{$this->longitude}'}";
    }
}
