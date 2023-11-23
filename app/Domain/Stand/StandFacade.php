<?php

namespace App\Domain\Stand;

interface StandFacade
{
    /**
     * Method returns all fetched Stand entities in array
     * @return array<Stand> Stand array
     */
    public function getAll(): array;

    /**
     * Method fetch Stand of given identifier
     * @param string $id stand identifier
     * @return ?Stand stand
     */
    public function get(string $id): ?Stand;

    /**
     * Method updates existing or creates new Stand entity with given information
     * @param Stand|null $stand
     * @param string $name
     * @param $latitude
     * @param $longtitude
     * @return void
     */
    public function save(?Stand $stand, string $name, $latitude, $longtitude): void;
}