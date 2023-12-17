<?php declare(strict_types = 1);

namespace App\UI\Modules\Front\Home;

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
    private RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory;

    public function __construct(
        RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory,
    )
    {
        $this->rideableBikesAndStandMapFactory = $rideableBikesAndStandMapFactory;
    }

    public function actionDefault(): void
    {
        $this->template->bikeCount = 100;
        $this->template->standCount = 20;
        $this->template->ridesDone = 1256;
    }

    public function createComponentRideableBikesAndStandMap(): RideableBikesAndStandMap
    {
        return $this->rideableBikesAndStandMapFactory->create();
    }
}
