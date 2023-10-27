<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandFacade;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;
use Doctrine\ORM\QueryBuilder;

class StandListGrid extends BaseComponent
{
    private StandFacade $standFacade;
    private Translator $translator;

    public function __construct(
        StandFacade $standFacade,
        Translator $translator,
    )
    {
        $this->standFacade = $standFacade;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);

        $grid->setDataSource($this->standFacade->getAllQueryBuilder());

        $grid->addColumnText('name', 'Název');
        $grid->addColumnText('location', 'Lokace')
            ->setRenderer(function(Stand $stand)
            {
               return $stand->getLocation()->toString();
            });
        return $grid;
    }
}