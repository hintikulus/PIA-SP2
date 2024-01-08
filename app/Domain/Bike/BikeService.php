<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Ride\Ride;
use App\Model\Exception\Logic\BikeNotFoundException;

interface BikeService
{
    /**
     * Retrieves a bike entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the bike.
     * @return Bike The bike entity.
     * @throws BikeNotFoundException When the bike with the given ID is not found.
     */
    public function getById(string $id): Bike;

    /**
     * Retrieves an array of all bikes.
     *
     * @return array<Bike> An array containing all available bike entities.
     */
    public function getAllBikes(): array;

    /**
     * Retrieves the data source for all bikes.
     *
     * @return mixed The data source for all bikes.
     */
    public function getAllBikesDataSource(): mixed;

    /**
     * Retrieves an array of rideable bikes.
     *
     * @return array<Bike> An array containing all rideable bike entities.
     */
    public function getRideableBikes(): array;

    /**
     * Retrieves an array of bikes due for service.
     *
     * @return array<Bike> An array containing all bikes due for service.
     */
    public function getBikesDueForService(): array;

    /**
     * Retrieves the data source for bikes due for service.
     *
     * @return mixed The data source for bikes due for service.
     */
    public function getBikesDueForServiceDataSource(): mixed;

    /**
     * Marks a bike as serviced.
     *
     * @param Bike $bike The bike entity to mark as serviced.
     */
    public function markServiced(Bike $bike): void;

    /**
     * Moves a bike within a ride to the specified location.
     *
     * @param Ride $ride The ride in which the bike is being moved.
     * @param Location $location The new location for the bike within the ride.
     */
    public function moveBikeinRide(Ride $ride, Location $location): void;

    /**
     * Creates a new bike entity associated with the specified stand.
     *
     * @param string $standId The unique identifier of the stand where the bike will be located.
     * @return Bike The newly created bike entity.
     */
    public function createBike(string $standId): Bike;

    /**
     * Updates an existing bike entity with the provided information.
     *
     * @param Bike $bike The bike entity to update.
     * @param string|null $standId The unique identifier of the stand where the bike will be located (nullable for no stand change).
     * @param \DateTime $lastServiceDatetime The datetime of the last service for the bike.
     */
    public function updateBike(Bike $bike, ?string $standId, \DateTime $lastServiceDatetime);
}
