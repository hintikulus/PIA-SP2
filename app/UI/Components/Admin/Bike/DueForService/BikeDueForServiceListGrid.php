<?php

namespace App\UI\Components\Admin\Bike\DueForService;

use App\Domain\Bike\BikeService;
use App\Model\App;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class BikeDueForServiceListGrid extends BaseComponent
{
    private BikeService $bikeService;
    private Translator $translator;

    public function __construct(
        BikeService $bikeService,
        Translator  $translator,
    )
    {
        $this->bikeService = $bikeService;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $translator = $this->translator->createPrefixedTranslator('admin.bikeDueForServiceListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->bikeService->getBikesDueForServiceDataSource());

        $grid->addColumnText('id', 'ID');

        $grid->addColumnDateTime('last_service_datetime', $translator->translate('column_last_service_datetime'), 'lastServiceTimestamp')
            ->setFormat(App::DATETIME_FORMAT)
            ->setSortable()
        ;

        $grid->addColumnText('stand', $translator->translate('column_stand'), 'stand.name');

        $grid->addAction('service', $translator->translate('action_service'), 'Bike:service')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0')
        ;

        return $grid;
    }
}
