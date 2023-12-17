<?php

namespace App\Model\Exception\Logic;

use App\Domain\Bike\Bike;
use App\Model\Exception\LogicException;

class BikeNotServiceableException extends LogicException
{
    public readonly string $bike;

    public function __construct(Bike $bike)
    {
        parent::__construct("Bike {$bike} has not passed its service period yet.");
        $this->bike = $bike;
    }
}