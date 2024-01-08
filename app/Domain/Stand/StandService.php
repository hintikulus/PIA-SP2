<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Exception\Logic\StandNotFoundException;

interface StandService
{
    /**
     * Retrieves a stand entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the stand.
     * @return Stand The stand entity.
     * @throws StandNotFoundException When the stand with the given ID is not found.
     */
    public function getById(string $id): Stand;

    /**
     * Retrieves an array of all stands.
     *
     * @return array<Stand> An array containing all available stand entities.
     */
    public function getAll(): array;

    /**
     * Retrieves the data source for all stands.
     *
     * @return mixed The data source for all stands.
     */
    public function getAllDataSource(): mixed;

    /**
     * Creates a new stand entity with the given information.
     *
     * @param string $name The name of the stand.
     * @param Location $location The location of the stand.
     * @return Stand The newly created stand entity.
     */
    public function createStand(string $name, Location $location): Stand;

    /**
     * Updates an existing stand entity with the given information.
     *
     * @param Stand $stand The stand entity to update.
     * @param string $name The new name of the stand.
     * @param Location $location The new location of the stand.
     */
    public function updateStand(Stand $stand, string $name, Location $location): void;
}