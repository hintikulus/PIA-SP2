<?php

namespace App\UI\Components\Admin\Bike\DueForService;

use App\Domain\Bike\BikeQuery;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class BikeDueForServiceListGrid extends BaseComponent
{
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;

    public function __construct(
        QueryBuilderManager $queryBuilderManager,
        Translator          $translator,
    )
    {
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $translator = $this->translator->createPrefixedTranslator('admin.bikeDueForServiceListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);

        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(BikeQuery::getDueForService()));

        $grid->addColumnText('id', 'ID');

        $grid->addColumnDateTime('last_service_datetime', $translator->translate('column_last_service_datetime'), 'last_service_timestamp')
            ->setFormat(App::DATETIME_FORMAT)
        ;

        $grid->addColumnText('stand', $translator->translate('column_stand'), 'stand.name');

        $grid->addAction('service', $translator->translate('action_service'), 'Bike:service')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0');

        return $grid;
    }
}
