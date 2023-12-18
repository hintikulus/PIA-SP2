<?php

namespace App\Domain\Bike;

interface BikeLocationNotifyManager
{
    public function notifyChangedBikeLocation(Bike $bike): void;
}
