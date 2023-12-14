<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;

interface RideProgressMapFactory
{
    public function create(Ride $ride): RideProgressMap;
}
