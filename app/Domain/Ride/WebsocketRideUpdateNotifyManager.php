<?php

namespace App\Domain\Ride;

use App\Domain\Bike\BikeTransformer;
use App\Domain\Location\Location;
use IPub\WebSocketsZMQ\Pusher\Pusher;

class WebsocketRideUpdateNotifyManager implements RideUpdateNotifyManager
{
    private Pusher $pusher;
    private BikeTransformer $bikeTransformer;

    public function __construct(
        Pusher $pusher,
        BikeTransformer $bikeTransformer,
    )
    {
        $this->pusher = $pusher;
        $this->bikeTransformer = $bikeTransformer;
    }

    public function notifyRideBikeLocationUpdate(Ride $ride, Location $location): void
    {
        $data = $this->bikeTransformer->transformBikeLocationUpdateData($ride->getBike(), $location);

        $this->pusher->push($data, 'Bike:', ['state' => 'rideable']);
        $this->pusher->push($data, 'Bike:', ['state' => 'all']);

        $this->pusher->push($data, 'Ride:', ['ride' => $ride->getId()->toString()]);
    }
}
