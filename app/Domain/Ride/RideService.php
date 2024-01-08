<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\Exception\Logic\RideNotFoundException;

interface RideService
{
    /**
     * Retrieves a ride entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the ride.
     * @return Ride The ride entity.
     * @throws RideNotFoundException When the ride with the given ID is not found.
     */
    public function getById(string $id): Ride;

    /**
     * Finds a ride entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the ride.
     * @return Ride|null The ride entity if found, or null if the ride is not found.
     */
    public function findById(string $id): ?Ride;

    /**
     * Retrieves an array of rides associated with the specified user.
     *
     * @param User $user The user for whom to retrieve rides.
     * @return array<Ride> An array containing all rides associated with the user.
     */
    public function getUserRides(User $user): array;

    /**
     * Retrieves the data source for rides associated with the specified user.
     *
     * @param User $user The user for whom to retrieve the data source.
     * @return mixed The data source for rides associated with the user.
     */
    public function getUserRidesDataSource(User $user): mixed;

    /**
     * Starts a new ride for the specified user and bike.
     *
     * @param User $user The user starting the ride.
     * @param Bike $bike The bike used for the ride.
     * @return Ride The newly started ride entity.
     */
    public function startRide(User $user, Bike $bike): Ride;

    /**
     * Completes the specified ride by parking the bike at the provided stand.
     *
     * @param Ride $ride The ride to complete.
     * @param Stand $stand The stand where the bike is being parked.
     */
    public function completeRide(Ride $ride, Stand $stand): void;

    /**
     * Checks if the specified user is currently in an active ride.
     *
     * @param User $user The user to check.
     * @return bool True if the user is in an active ride, false otherwise.
     */
    public function isUserInRide(User $user): bool;

    /**
     * Finds the active ride associated with the specified user.
     *
     * @param User $user The user for whom to find the active ride.
     * @return Ride|null The active ride entity if found, or null if there is no active ride for the user.
     */
    public function findUsersActiveRide(User $user): ?Ride;
}