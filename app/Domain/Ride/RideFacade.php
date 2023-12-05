<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;

interface RideFacade
{
    public function get(string $id): ?Ride;

    public function startRide(User $user, Bike $bikeId, Stand $startStandId): Ride;
}
