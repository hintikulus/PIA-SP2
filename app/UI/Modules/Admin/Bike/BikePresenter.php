<?php

namespace App\UI\Modules\Admin\Bike;

use App\UI\Components\Admin\Bike\BikeListGrid;
use App\UI\Components\Admin\Bike\BikeListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class BikePresenter extends BaseAdminPresenter
{
    private BikeListGridFactory $bikeListGridFactory;

    public function __construct(
        BikeListGridFactory $bikeListGridFactory,
    )
    {
        $this->bikeListGridFactory = $bikeListGridFactory;
    }

    public function createComponentBikeListGrid(): BikeListGrid
    {
        return $this->bikeListGridFactory->create();
    }
}