<?php

namespace App\Domain\Bike;

use IPub\WebSocketsZMQ\Pusher\Pusher;

class WebsocketBikeLocationNotifyManager implements BikeLocationNotifyManager
{
    private Pusher $pusher;

    public function __construct(
        Pusher $pusher,
    )
    {
        $this->pusher = $pusher;
    }

    public function notifyChangedBikeLocation(Bike $bike): void
    {
        // TODO: Implement notifyChangedBikeLocation() method.
    }

}
