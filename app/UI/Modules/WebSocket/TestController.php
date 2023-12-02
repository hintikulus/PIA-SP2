<?php

namespace App\UI\Modules\WebSocket;

use IPub\WebSocketsWAMP\Entities\Clients\IClient;
use IPub\WebSocketsWAMP\Entities\Topics\ITopic;
use Nette\Security\User;
use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\ILogger;

class TestController extends BaseWebSocketController
{

    /**
     * Akce která se zavolá když JS klient zavolá publish metodu.
     *
     * @param IClient $client	- Klient který akci vyvolal
     * @param ITopic $topic		- Topic kterého se akce týká
     */
    public function actionPublish(array $event, IClient $client, ITopic $topic)
    {
        $outgoing = new \stdClass();
        $outgoing->time = (new \DateTime())->format('Y-m-d H:i:s');
        $outgoing->from = $client->getId();
        $outgoing->content = $event['message'];

        Debugger::log($outgoing->content, ILogger::DEBUG);

        // Odešleme všem, i tomu kdo zprávu poslal
        //$topic->broadcast(Json::encode($outgoing));

        // Pošleme všem, vyjma toho kdo zprávu poslal
        $topic->broadcast(Json::encode($outgoing), [$client->getId()]);


        var_dump($client->getId());
    }
}
