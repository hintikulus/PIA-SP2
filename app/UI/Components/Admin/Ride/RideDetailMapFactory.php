<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;

interface RideDetailMapFactory
{
    public function create(Ride $ride): RideDetailMap;
}