<?php

namespace App\UI\Modules\Admin\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeFacade;
use App\Model\Exception\Logic\BikeNotFoundException;
use App\UI\Components\Admin\Bike\BikeChooseStandMap;
use App\UI\Components\Admin\Bike\BikeChooseStandMapFactory;
use App\UI\Components\Admin\Bike\BikeForm;
use App\UI\Components\Admin\Bike\BikeFormFactory;
use App\UI\Components\Admin\Bike\BikeListGrid;
use App\UI\Components\Admin\Bike\BikeListGridFactory;
use App\UI\Components\Admin\Bike\BikeListMap;
use App\UI\Components\Admin\Bike\BikeListMapFactory;
use App\UI\Components\Admin\Bike\DueForService\BikeDueForServiceListGrid;
use App\UI\Components\Admin\Bike\DueForService\BikeDueForServiceListGridFactory;
use App\UI\Components\Admin\Bike\DueForService\BikeDueForServiceListMap;
use App\UI\Components\Admin\Bike\DueForService\BikeDueForServiceListMapFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class BikePresenter extends BaseAdminPresenter
{
    private BikeFacade $bikeFacade;
    private BikeChooseStandMapFactory $bikeChooseStandMapFactory;
    private BikeListGridFactory $bikeListGridFactory;
    private BikeListMapFactory $bikeListMapFactory;
    private BikeFormFactory $bikeFormFactory;
    private BikeDueForServiceListGridFactory $bikeDueForServiceListGridFactory;
    private BikeDueForServiceListMapFactory $bikeDueForServiceListMapFactory;

    private ?Bike $bike = null;

    public function __construct(
        BikeFacade $bikeFacade,
        BikeListGridFactory       $bikeListGridFactory,
        BikeChooseStandMapFactory $bikeChooseStandMapFactory,
        BikeFormFactory           $bikeFormFactory,
        BikeListMapFactory $bikeListMapFactory,
        BikeDueForServiceListGridFactory $bikeDueForServiceListGridFactory,
        BikeDueForServiceListMapFactory $bikeDueForServiceListMapFactory,
    )
    {
        $this->bikeFacade = $bikeFacade;
        $this->bikeListGridFactory = $bikeListGridFactory;
        $this->bikeChooseStandMapFactory = $bikeChooseStandMapFactory;
        $this->bikeFormFactory = $bikeFormFactory;
        $this->bikeListMapFactory = $bikeListMapFactory;
        $this->bikeDueForServiceListGridFactory = $bikeDueForServiceListGridFactory;
        $this->bikeDueForServiceListMapFactory = $bikeDueForServiceListMapFactory;
    }

    public function actionEdit(string $id)
    {
        $bike = $this->bikeFacade->get($id);

        if($bike === null)
        {
            throw new BikeNotFoundException($id);
        }

        $this->bike = $bike;
    }

    public function actionService(string $id)
    {
        $bike = $this->bikeFacade->get($id);

        if($bike === null)
        {
            throw new BikeNotFoundException($id);
        }

        $this->bike = $bike;
    }

    public function createComponentBikeListGrid(): BikeListGrid
    {
        return $this->bikeListGridFactory->create();
    }

    public function createComponentBikeChooseStandMap(): BikeChooseStandMap
    {
        return $this->bikeChooseStandMapFactory->create();
    }

    public function createComponentBikeListMap(): BikeListMap
    {
        return $this->bikeListMapFactory->create();
    }

    public function createComponentBikeForm(): BikeForm
    {
        $form = $this->bikeFormFactory->create($this->bike, $this->link(':list'));
        $form['form']->onSuccess[] = function() {
            $this->redirect(':list');
        };
        return $form;
    }

    public function createComponentBikeDueForServiceListGrid(): BikeDueForServiceListGrid
    {
        return $this->bikeDueForServiceListGridFactory->create();
    }

    public function createComponentBikeDueForServiceListMap(): BikeDueForServiceListMap
    {
        return $this->bikeDueForServiceListMapFactory->create();
    }

    public function handleMakeBikeService(string $id): void
    {
        $bike = $this->bikeFacade->get($id);

        if($bike === null)
        {
            throw new BikeNotFoundException($id);
        }

        $this->bikeFacade->makeService($bike);
        $this->flashSuccess($this->presenterTranslator->translate('signal_makeBikeService.flash_success'));
        $this->redirect(':dueForService');
    }
}
