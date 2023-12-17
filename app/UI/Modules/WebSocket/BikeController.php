<?php

namespace App\UI\Modules\WebSocket;

use App\Domain\Bike\BikeService;
use App\Domain\Location\Location;
use App\Model\App;
use App\Model\Utils\DateTime;
use IPub\WebSocketsWAMP\Entities\Clients\IClient;
use IPub\WebSocketsWAMP\Entities\Topics\ITopic;
use Nette\Utils\Json;

class BikeController extends BaseWebSocketController
{
    public function __contruct()
    {
    }

    public function publish(array $event, IClient $client, ITopic $topic)
    {
        $outgoing = new \stdClass();
        $outgoing->time = (new DateTime())->format(App::DATETIME_FORMAT);
        $outgoing->from = $client->getId();
        $outgoing->content = $event['message'];

    }

    public function actionPush(array $data, ITopic $topic)
    {
        $now = new DateTime();
        $location = $data['location'];

        $message = new \stdClass();
        $message->time = $now->format(App::DATETIME_PICKER_FORMAT);
        $message->content = [
            'bike_id'  => $data['bike_id'],
            'location' => [
                'lat'  => $location['latitude'],
                'long' => $location['longitude'],
            ],
        ];
        $message->type = 'bike_update';

        $topic->broadcast(Json::encode($message));
    }
}
