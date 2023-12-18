<?php

namespace App\Domain\Ride;

use App\Domain\Location\Location;

interface RideUpdateNotifyManager
{
    public function notifyRideBikeLocationUpdate(Ride $ride, Location $location): void;
}
