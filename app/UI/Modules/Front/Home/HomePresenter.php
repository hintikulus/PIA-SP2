<?php declare(strict_types = 1);

namespace App\UI\Modules\Front\Home;

use App\Domain\Bike\BikeFacade;
use App\Domain\Location\Location;
use App\Domain\User\UserFacade;
use App\Model\Exception\Logic\BikeNotFoundException;
use App\UI\Components\Front\RideableBikesAndStandMap\RideableBikesAndStandMap;
use App\UI\Components\Front\RideableBikesAndStandMap\RideableBikesAndStandMapFactory;
use App\UI\Modules\Front\BaseFrontPresenter;
use IPub\WebSocketsZMQ\Pusher\Pusher;
use Nette\Utils\Random;
use Random\Randomizer;

final class HomePresenter extends BaseFrontPresenter
{
    private UserFacade $userFacade;
    private RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory;

    public function __construct(
        UserFacade                      $userFacade,
        private BikeFacade              $bikeFacade,
        private Pusher                  $zmgPusher,
        RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory,
    )
    {
        $this->userFacade = $userFacade;
        $this->rideableBikesAndStandMapFactory = $rideableBikesAndStandMapFactory;
    }

    public function actionDefault(): void
    {
        $this->template->bikeCount = 100;
        $this->template->standCount = 20;
        $this->template->ridesDone = 1256;
    }

    public function handleCreateUser()
    {
        $this->userFacade->createUserFromArray([
            'name'     => 'Test',
            'email'    => 'test@test.cz',
            'password' => 'password',
        ]);
    }

    public function handleRandomizeBikeLocation(string $bikeId)
    {
        $bike = $this->bikeFacade->get($bikeId);

        if ($bike === null)
        {
            throw new BikeNotFoundException($bikeId);
        }

        $newLocation = $bike->getLocation();

        $newLocation = new Location(
            strval($this->rand_float(49.72010000, 49.76539999)),
            strval($this->rand_float(13.35070000, 13.39199999))
        );

        $this->bikeFacade->updateLocation($bike, $newLocation);

        $this->zmgPusher->push([
            'bike_id'  => $bike->getId()->toString(),
            'location' => $bike->getLocation()
        ], 'Bike:', [
            'state' => 'stand',
        ]);
    }

    public function createComponentRideableBikesAndStandMap(): RideableBikesAndStandMap
    {
        return $this->rideableBikesAndStandMapFactory->create();
    }

    private function rand_float(float $minValue, float $maxValue): float
    {
        return $minValue + mt_rand() / mt_getrandmax() * ($maxValue - $minValue);
    }
}
