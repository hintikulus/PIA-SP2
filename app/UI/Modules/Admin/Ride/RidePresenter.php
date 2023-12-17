<?php

namespace App\UI\Modules\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Ride\RideService;
use App\Model\Exception\Logic\RideNotFoundException;
use App\UI\Components\Admin\Ride\RideDetailMap;
use App\UI\Components\Admin\Ride\RideDetailMapFactory;
use App\UI\Components\Admin\Ride\RideProgressMap;
use App\UI\Components\Admin\Ride\RideProgressMapFactory;
use App\UI\Components\Front\RideableBikesAndStandMap\RideableBikesAndStandMap;
use App\UI\Components\Front\RideableBikesAndStandMap\RideableBikesAndStandMapFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class RidePresenter extends BaseAdminPresenter
{
    private RideService $rideService;
    private RideProgressMapFactory $rideProgressMapFactory;
    private RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory;
    private RideDetailMapFactory $rideDetailMapFactory;

    private Ride $ride;

    public function __construct(
        RideService                      $rideService,
        RideProgressMapFactory          $rideProgressMapFactory,
        RideableBikesAndStandMapFactory $rideableBikesAndStandMapFactory,
        RideDetailMapFactory            $rideDetailMapFactory,
    )
    {
        $this->rideService = $rideService;
        $this->rideProgressMapFactory = $rideProgressMapFactory;
        $this->rideableBikesAndStandMapFactory = $rideableBikesAndStandMapFactory;
        $this->rideDetailMapFactory = $rideDetailMapFactory;
    }

    public function actionDetail(string $id)
    {
        $this->ride = $this->rideService->getById($id);
        $this->template->ride = $this->ride;
    }

    public function createComponentRideProgressMap(): RideProgressMap
    {
        $map = $this->rideProgressMapFactory->create($this->ride);
        $map->onRideEnd[] = function() {
            $this->redrawControl('rideDetailsMapCard');
            $this->redrawControl('rideDetailsCard');
        };
        return $map;
    }

    public function createComponentRideableBikesAndStandMap(): RideableBikesAndStandMap
    {
        return $this->rideableBikesAndStandMapFactory->create();
    }

    public function createComponentRideDetailMap(): RideDetailMap
    {
        return $this->rideDetailMapFactory->create($this->ride);
    }

}
