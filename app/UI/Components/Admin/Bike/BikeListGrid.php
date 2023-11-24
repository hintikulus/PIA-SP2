<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\BikeQuery;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class BikeListGrid extends BaseComponent
{
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;

    public function __construct(
        QueryBuilderManager $queryBuilderManager,
        Translator $translator,
    )
    {
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(BikeQuery::getAll()));
        $grid->addColumnText('id', 'ID');

        return $grid;
    }
}