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
}