<?php

namespace App\UI\Modules\WebSocket;

use App\Domain\Location\Location;
use App\Model\App;
use App\Model\Router\RouterFactory;
use App\Model\Utils\DateTime;
use IPub\WebSocketsWAMP\Entities\Clients\IClient;
use IPub\WebSocketsWAMP\Entities\Topics\ITopic;
use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\ILogger;

class RideController extends BaseWebSocketController
{
    public function __construct(
        private RouterFactory $routerFactory,
    )
    {
    }

    public function actionPush(array $data, ITopic $topic)
    {
        $topic->broadcast(Json::encode($data));
    }
}
