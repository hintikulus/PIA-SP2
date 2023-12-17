<?php

namespace App\Model\Exception\Logic;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Model\Exception\LogicException;

class BikeTooFarFromEndStand extends LogicException
{
    public readonly Bike $bike;
    public readonly Stand $stand;
    public function __construct(Bike $bike, Stand $stand)
    {
        parent::__construct("Bike {$bike} is too far from stand {$stand}");
        $this->bike = $bike;
        $this->stand = $stand;
    }

}