<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;

interface BikeManager
{
    public function getById(string $id): Bike;

    public function findById(string $id): ?Bike;

    public function createBike(Stand $stand): Bike;

    public function save(Bike $bike): void;
}