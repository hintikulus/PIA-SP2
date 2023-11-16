<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandFacade;
use App\Domain\Stand\StandQuery;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;
use Doctrine\ORM\QueryBuilder;

class StandListGrid extends BaseComponent
{
    private StandFacade $standFacade;
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;

    public function __construct(
        StandFacade $standFacade,
        QueryBuilderManager $queryBuilderManager,
        Translator $translator,
    )
    {
        $this->standFacade = $standFacade;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);

        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(StandQuery::getAll()));

        $grid->addColumnText('name', 'Název');
        $grid->addColumnText('location', 'Lokace')
            ->setRenderer(function(Stand $stand)
            {
               return $stand->getLocation()->toString();
            });
        return $grid;
    }
}