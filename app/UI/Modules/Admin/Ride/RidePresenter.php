<?php

namespace App\UI\Modules\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Ride\RideFacade;
use App\Model\Exception\Logic\RideNotFoundException;
use App\UI\Components\Admin\Ride\RideProgressMapFactory;
use App\UI\Components\Front\RideableBikesAndStandMap\RideableBikesAndStandMapFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class RidePresenter extends BaseAdminPresenter
{
    private RideFacade $rideFacade;
    private RideProgressMapFactory $rideProgressMapFactory;
    private RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory;

    private Ride $ride;

    public function __construct(
        RideFacade $rideFacade,
        RideProgressMapFactory $rideProgressMapFactory,
        RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory,
    )
    {
        $this->rideFacade = $rideFacade;
        $this->rideProgressMapFactory = $rideProgressMapFactory;
        $this->rideableBikesAndStandMapFactory = $rideableBikesAndStandMapFactory;
    }

    public function actionDetail(string $id)
    {
        $ride = $this->rideFacade->get($id);
        if($ride === null)
        {
            throw new RideNotFoundException($id);
        }

        $this->ride = $ride;
        $this->template->ride = $ride;
    }

    public function createComponentRideProgressMap()
    {
        return $this->rideProgressMapFactory->create($this->ride);
    }

    public function createComponentRideableBikesAndStandMap()
    {
        return $this->rideableBikesAndStandMapFactory->create();
    }

}
