<?php

namespace App\UI\Modules\Admin\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeService;
use App\Model\Exception\Logic\BikeNotFoundException;
use App\Model\Exception\Logic\BikeNotServiceableException;
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
use Nette\Application\ForbiddenRequestException;

class BikePresenter extends BaseAdminPresenter
{
    private BikeService $bikeService;
    private BikeChooseStandMapFactory $bikeChooseStandMapFactory;
    private BikeListGridFactory $bikeListGridFactory;
    private BikeListMapFactory $bikeListMapFactory;
    private BikeFormFactory $bikeFormFactory;
    private BikeDueForServiceListGridFactory $bikeDueForServiceListGridFactory;
    private BikeDueForServiceListMapFactory $bikeDueForServiceListMapFactory;

    private ?Bike $bike = null;

    public function __construct(
        BikeService                      $bikeService,
        BikeListGridFactory              $bikeListGridFactory,
        BikeChooseStandMapFactory        $bikeChooseStandMapFactory,
        BikeFormFactory                  $bikeFormFactory,
        BikeListMapFactory               $bikeListMapFactory,
        BikeDueForServiceListGridFactory $bikeDueForServiceListGridFactory,
        BikeDueForServiceListMapFactory  $bikeDueForServiceListMapFactory,
    )
    {
        $this->bikeService = $bikeService;
        $this->bikeListGridFactory = $bikeListGridFactory;
        $this->bikeChooseStandMapFactory = $bikeChooseStandMapFactory;
        $this->bikeFormFactory = $bikeFormFactory;
        $this->bikeListMapFactory = $bikeListMapFactory;
        $this->bikeDueForServiceListGridFactory = $bikeDueForServiceListGridFactory;
        $this->bikeDueForServiceListMapFactory = $bikeDueForServiceListMapFactory;
    }

    public function actionEdit(string $id): void
    {
        $this->bike = $this->bikeService->getById($id);

        if (!$this->user->isAllowed($this->bike, 'edit'))
        {
            throw new ForbiddenRequestException();
        }
    }

    public function actionService(string $id): void
    {
        $this->bike = $this->bikeService->getById($id);

        if(!$this->user->isAllowed($this->bike, 'service'))
        {
            throw new ForbiddenRequestException();
        }
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
        $bike = $this->bikeService->getById($id);

        if (!$this->user->isAllowed($bike, 'service'))
        {
            throw new ForbiddenRequestException();
        }

        try
        {
            $this->bikeService->markServiced($bike);
        }
        catch (BikeNotServiceableException)
        {
            $this->flashWarning($this->presenterTranslator->translate('signal_makeBikeService.flash_bikeNotServiceable'));
            return;
        }
        catch (\Exception)
        {
            $this->flashWarning($this->presenterTranslator->translate('signal_makeBikeService.flash_error'));
            return;
        };

        $this->flashSuccess($this->presenterTranslator->translate('signal_makeBikeService.flash_success'));
        $this->redirect(':dueForService');
    }
}
