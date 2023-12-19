<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\User\User;

interface RideManager
{
    public function getById(string $id): Ride;

    public function findById(string $id): ?Ride;

    public function findActiveByUser(User $user): ?Ride;

    public function startRide(User $user, Bike $bike, \DateInterval $serviceInterval): Ride;
    public function save(Ride $ride): void;
}