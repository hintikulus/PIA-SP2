<?php

namespace App\Domain\Bike;

interface BikeFacade
{
    /**
     * Method returns Bike entity of given identifier
     * @param string $id bike identifier
     * @return Bike|null bike or null if not exists
     */
    public function get(string $id): ?Bike;

    /**
     * @return array<Bike>
     */
    public function getAll(): array;

    public function save(?Bike $bike, ?string $stand_id, ?\DateTime $last_service_datetime): Bike;
}