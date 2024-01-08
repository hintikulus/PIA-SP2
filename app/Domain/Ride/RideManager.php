<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\User\User;
use App\Model\Exception\Logic\RideNotFoundException;

interface RideManager
{
    /**
     * Retrieves a ride entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the ride.
     * @return Ride The ride entity.
     * @throws RideNotFoundException When the ride with the given ID is not found.
     */
    public function getById(string $id): Ride;

    /**
     * Finds a ride entity from the repository based on the provided ID.
     *
     * @param string $id The unique identifier of the ride.
     * @return Ride|null The ride entity if found, or null if the ride is not found.
     */
    public function findById(string $id): ?Ride;

    /**
     * Finds the active ride entity for the given user.
     *
     * @param User $user The user for whom to find the active ride.
     * @return Ride|null The active ride entity if found, or null if there is no active ride for the user.
     */
    public function findActiveByUser(User $user): ?Ride;

    /**
     * Starts a new ride for the specified user and bike with the given service interval.
     *
     * @param User $user The user starting the ride.
     * @param Bike $bike The bike used for the ride.
     * @param \DateInterval $serviceInterval The service interval for the bike.
     * @return Ride The newly started ride entity.
     */
    public function startRide(User $user, Bike $bike, \DateInterval $serviceInterval): Ride;

    /**
     * Saves the changes made to a ride entity in the repository.
     *
     * @param Ride $ride The ride entity to be saved.
     */
    public function save(Ride $ride): void;
}