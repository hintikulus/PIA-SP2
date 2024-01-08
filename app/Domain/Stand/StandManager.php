<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Exception\Logic\StandNotFoundException;

interface StandManager
{
    /**
     * Retrieves a stand entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the stand.
     * @return Stand The stand entity.
     * @throws StandNotFoundException When the stand with the given ID is not found.
     */
    public function getById(string $id): Stand;

    /**
     * Finds a stand entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the stand.
     * @return Stand|null The stand entity if found, or null if the stand is not found.
     */
    public function findById(string $id): ?Stand;

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

    /**
     * Saves the changes made to a stand entity in the repository.
     *
     * @param Stand $stand The stand entity to be saved.
     */
    public function save(Stand $stand): void;
}