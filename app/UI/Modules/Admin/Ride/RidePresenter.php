<?php

namespace App\UI\Modules\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Ride\RideFacade;
use App\Model\Exception\Logic\RideNotFoundException;
use App\UI\Modules\Admin\BaseAdminPresenter;

class RidePresenter extends BaseAdminPresenter
{
    private RideFacade $rideFacade;

    private Ride $ride;

    public function __construct(
        RideFacade $rideFacade,
    )
    {
        $this->rideFacade = $rideFacade;
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

}