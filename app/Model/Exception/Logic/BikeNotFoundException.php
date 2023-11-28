<?php

namespace App\Model\Exception\Logic;

use App\Domain\Bike\Bike;
use App\Model\Exception\LogicException;

class BikeNotFoundException extends LogicException
{
    public readonly string $bikeId;

    public function __construct(string $bikeId)
    {
        parent::__construct("Bike {$bikeId} was not found.");
        $this->bikeId = $bikeId;
    }

}
