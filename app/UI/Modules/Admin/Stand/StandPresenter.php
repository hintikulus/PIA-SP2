<?php

namespace App\UI\Modules\Admin\Stand;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandFacade;
use App\Model\Exception\Logic\StandNotFoundException;
use App\UI\Components\Admin\Stand\StandChooseMap;
use App\UI\Components\Admin\Stand\StandChooseMapFactory;
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
    private StandChooseMapFactory $standChooseMapFactory;
    private StandFacade $standFacade;

    private ?Stand $stand = null;

    public function __construct(
        StandListGridFactory $standListGridFactory,
        StandListMapFactory  $standListMapFactory,
        StandFormFactory     $standFormFactory,
        StandChooseMapFactory $standChooseMapFactory,
        StandFacade   $standFacade,
    )
    {
        $this->standListGridFactory = $standListGridFactory;
        $this->standListMapFactory = $standListMapFactory;
        $this->standFormFactory = $standFormFactory;
        $this->standChooseMapFactory = $standChooseMapFactory;
        $this->standFacade = $standFacade;
    }

    public function actionEdit(string $id)
    {
        $stand = $this->standFacade->get($id);

        if($stand === null)
        {
            throw new StandNotFoundException($id);
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
        $form = $this->standFormFactory->create($this->stand, $this->link(':list'));
        $form['form']->onSuccess[] = function()
        {
            $this->redirect(':list');
        };
        return $form;
    }

    public function createComponentStandChooseMap(): StandChooseMap
    {
        return $this->standChooseMapFactory->create($this->stand);
    }
}
