<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;

interface StandManager
{
    public function getById(string $id): Stand;

    public function findById(string $id): ?Stand;

    public function createStand(string $name, Location $location);

    public function updateStand(Stand $stand, string $name, Location $location);

    public function save(Stand $stand): void;
}