<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;

interface StandService
{
    public function getById(string $id): Stand;

    public function getAll(): array;

    public function getAllDataSource(): mixed;

    public function createStand(string $name, Location $location): Stand;

    public function updateStand(Stand $stand, string $name, Location $location): void;
}