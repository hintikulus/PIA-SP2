<?php

namespace App\Model\Exception\Logic;

use App\Model\Exception\LogicException;

class RideNotFoundException extends LogicException
{
    public readonly string $rideId;

    public function __construct(string $rideId)
    {
        parent::__construct("Ride {$rideId} was not found.", 404);
        $this->rideId = $rideId;
    }

}
