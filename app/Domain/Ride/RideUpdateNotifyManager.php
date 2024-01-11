<?php

namespace App\Domain\Ride;

use App\Domain\Location\Location;

/**
 * Interface for notifying updates related to the Ride entity.
 */
interface RideUpdateNotifyManager
{
    /**
     * Notifies the update of the bike location during a ride.
     *
     * @param Ride $ride The Ride entity for which the bike location is updated.
     * @param Location $location The updated Location of the bike during the ride.
     */
    public function notifyRideBikeLocationUpdate(Ride $ride, Location $location): void;
}
