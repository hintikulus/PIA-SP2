<?php

namespace App\UI\Modules\Admin\Stand;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandFacade;
use App\UI\Components\Admin\Stand\StandForm;
use App\UI\Components\Admin\Stand\StandFormFactory;
use App\UI\Components\Admin\Stand\StandListGrid;
use App\UI\Components\Admin\Stand\StandListGridFactory;
use App\UI\Components\Admin\Stand\StandListMap;
use App\UI\Components\Admin\Stand\StandListMapFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class StandPresenter extends BaseAdminPresenter
{
    private StandListGridFactory $standListGridFactory;
    private StandListMapFactory $standListMapFactory;
    private StandFormFactory $standFormFactory;
    private StandFacade $standFacade;

    private ?Stand $stand = null;

    public function __construct(
        StandListGridFactory $standListGridFactory,
        StandListMapFactory  $standListMapFactory,
        StandFormFactory     $standFormFactory,
        StandFacade   $standFacade,
    )
    {
        $this->standListGridFactory = $standListGridFactory;
        $this->standListMapFactory = $standListMapFactory;
        $this->standFormFactory = $standFormFactory;
        $this->standFacade = $standFacade;
    }

    public function actionEdit(string $id)
    {
        $stand = $this->standFacade->get($id);

        if($stand === null)
        {
            $this->error('Stojan nenalezen', 404);
        }

        $this->stand = $stand;
    }

    public function createComponentStandListGrid(): StandListGrid
    {
        return $this->standListGridFactory->create();
    }

    public function createComponentStandListMap(): StandListMap
    {
        return $this->standListMapFactory->create();
    }

    public function createComponentStandForm(): StandForm
    {
        return $this->standFormFactory->create($this->stand);
    }
}