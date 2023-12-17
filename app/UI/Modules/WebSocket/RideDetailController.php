<?php

namespace App\UI\Modules\WebSocket;

use App\Domain\Bike\BikeService;
use App\Domain\Location\Location;
use App\Domain\Ride\RideService;
use IPub\WebSocketsWAMP\Entities\Clients\IClient;
use IPub\WebSocketsWAMP\Entities\Topics\ITopic;
use IPub\WebSocketsZMQ\Pusher\Pusher;
use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\ILogger;

class RideDetailController extends BaseWebSocketController
{
    private RideService $rideService;
    private BikeService $bikeService;
    private Pusher $zmqPusher;

    public function __construct(
        RideService $rideService,
        BikeService $bikeService,
        Pusher $zmqPusher,
    )
    {
        $this->rideService = $rideService;
        $this->bikeService = $bikeService;
        $this->zmqPusher = $zmqPusher;
    }


    /**
     * Akce která se zavolá když JS klient zavolá publish metodu.
     *
     * @param IClient $client	- Klient který akci vyvolal
     * @param ITopic $topic		- Topic kterého se akce týká
     */
    public function actionPublish(array $event, IClient $client, ITopic $topic)
    {
        $type = $event['type'];
        $location = new Location($event['location']['lat'], $event['location']['lng']);
        $rideId = $event['ride_id'];

        $ride = $this->rideService->findById($rideId);

        if($ride === null || !$ride->isStarted())
        {
            $outgoing = new \stdClass();
            $outgoing->content = ['type' => 'error_message'];
            $client->send(Json::encode($outgoing));
            return;
        }

        try
        {
            $this->bikeService->moveBike($ride->getBike(), $location);
        } catch (\Exception)
        {
            return;
        }

        $this->zmqPusher->push([
            'bike_id'  => $ride->getBike()->getId()->toString(),
            'location' => $location,
        ], 'Bike:', [
            'state' => 'stand',
        ]);


        $this->zmqPusher->push([
            'bike_id'  => $ride->getBike()->getId()->toString(),
            'location' => $location,
        ], 'Ride:', [
            'ride' => $ride->getId()->toString(),
        ]);
        return;
    }
}