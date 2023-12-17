<?php

namespace App\Domain\Stand;

interface StandManager
{
    public function getById(string $id): Stand;
    public function findById(string $id): ?Stand;

    public function save(Stand $stand): void;
}