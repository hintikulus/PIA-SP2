<?php

namespace App\UI\Modules\Admin\Stand;

use App\Domain\Stand\StandFacade;
use App\UI\Components\Admin\Stand\StandListGrid;
use App\UI\Components\Admin\Stand\StandListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class StandPresenter extends BaseAdminPresenter
{
    private StandListGridFactory $standListGridFactory;

    public function __construct(
        StandListGridFactory $standListGridFactory,
    )
    {
        $this->standListGridFactory = $standListGridFactory;
    }

    public function createComponentStandListGrid(): StandListGrid
    {
        return $this->standListGridFactory->create();
    }
}