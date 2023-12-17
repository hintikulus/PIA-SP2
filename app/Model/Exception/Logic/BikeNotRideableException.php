<?php

namespace App\Model\Exception\Logic;

use App\Domain\Bike\Bike;
use App\Model\Exception\LogicException;

class BikeNotRideableException extends LogicException
{
    public readonly Bike $bike;

    public function __construct(Bike $bike)
    {
        parent::__construct("Bike {$bike} is not rideable.");
        $this->bike = $bike;
    }
}