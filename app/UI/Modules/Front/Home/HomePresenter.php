<?php declare(strict_types = 1);

namespace App\UI\Modules\Front\Home;

use App\UI\Components\Base\RideableBikesAndStandMap\RideableBikesAndStandMap;
use App\UI\Components\Base\RideableBikesAndStandMap\RideableBikesAndStandMapFactory;
use App\UI\Modules\Front\BaseFrontPresenter;

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

    }

    public function createComponentRideableBikesAndStandMap(): RideableBikesAndStandMap
    {
        return $this->rideableBikesAndStandMapFactory->create();
    }
}
