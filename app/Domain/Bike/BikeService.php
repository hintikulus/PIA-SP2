<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;

interface BikeService
{
    public function getById(string $id): Bike;

    /**
     * @return array<Bike>
     */
    public function getAllBikes(): array;

    public function getAllBikesDataSource(): mixed;

    /**
     * @return array<Bike>
     */
    public function getRideableBikes(): array;

    /**
     * @return array<Bike>
     */
    public function getBikesDueForService(): array;

    public function getBikesDueForServiceDataSource(): mixed;

    public function markServiced(Bike $bike): void;

    public function moveBike(Bike $bike, Location $location): void;

    public function createBike(string $standId): Bike;

    public function updateBike(Bike $bike, ?string $standId, \DateTime $lastServiceDatetime);
}