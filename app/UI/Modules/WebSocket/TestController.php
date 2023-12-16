<?php

namespace App\UI\Modules\WebSocket;

use App\Domain\Bike\BikeFacade;
use App\Model\App;
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
        var_dump('test');
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
        var_dump($this->user?->isLoggedIn());
    }

    public function actionTest(array $data, ITopic $topic)
    {
        $topic->broadcast($data);
    }

    public function actionPush(array $data, ITopic $topic)
    {
        $now = new \DateTime();
        $message = new \stdClass();
        $message->time = $now->format(App::DATETIME_PICKER_FORMAT);
        $message->content = 'zprava';
        $message->type = 'system';

        $topic->broadcast(Json::encode($message));

    }
}
