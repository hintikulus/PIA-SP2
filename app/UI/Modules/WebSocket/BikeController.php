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


    public function actionPush(array $data, ITopic $topic)
    {
        $topic->broadcast(Json::encode($data));
    }
}
