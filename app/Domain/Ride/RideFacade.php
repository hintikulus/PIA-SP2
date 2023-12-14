<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;

interface RideFacade
{
    public function get(string $id): ?Ride;

    public function startRide(User $user, Bike $bike): Ride;

    public function isUserInRide(User $user): bool;

    public function getUsersActiveRide(User $user): ?Ride;
}
