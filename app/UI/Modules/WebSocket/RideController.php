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

    /**
     * Akce která se zavolá když JS klient zavolá publish metodu.
     *
     * @param IClient $client	- Klient který akci vyvolal
     * @param ITopic $topic		- Topic kterého se akce týká
     */
    public function actionPublish(array $event, IClient $client, ITopic $topic)
    {
        var_dump('test');
        bdump('test');

        $type = $event['type'];
        $location = new Location($event['location']['lat'], $event['location']['lng']);

        var_dump($client->getId());

        var_dump($topic->getId());

        return;
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
