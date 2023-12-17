<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;

interface RideService
{
    public function getById(string $id): Ride;

    public function findById(string $id): ?Ride;

    public function getUserRides(User $user): array;

    public function getUserRidesDataSource(User $user): mixed;

    public function startRide(User $user, Bike $bike): Ride;

    public function completeRide(Ride $ride, Stand $stand): void;

    public function isUserInRide(User $user): bool;

    public function findUsersActiveRide(User $user): ?Ride;
}