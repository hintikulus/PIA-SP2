<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;
use App\Model\Exception\Logic\BikeNotFoundException;

interface BikeManager
{
    /**
     * Retrieves a bike entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the bike.
     * @return Bike The bike entity.
     * @throws BikeNotFoundException When the bike with the given ID is not found.
     */
    public function getById(string $id): Bike;

    /**
     * Finds a bike entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the bike.
     * @return Bike|null The bike entity if found, or null if the bike is not found.
     */
    public function findById(string $id): ?Bike;

    /**
     * Creates a new bike entity associated with the specified stand.
     *
     * @param Stand $stand The stand where the bike is located.
     * @return Bike The newly created bike entity.
     */
    public function createBike(Stand $stand): Bike;

    /**
     * Saves the changes made to a bike entity in the repository.
     *
     * @param Bike $bike The bike entity to be saved.
     */
    public function save(Bike $bike): void;
}