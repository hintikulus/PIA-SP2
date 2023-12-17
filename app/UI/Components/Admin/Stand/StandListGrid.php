<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandService;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class StandListGrid extends BaseComponent
{
    private StandService $standService;
    private Translator $translator;

    public function __construct(
        StandService $standService,
        Translator          $translator,
    )
    {
        $this->standService = $standService;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $translator = $this->translator->createPrefixedTranslator('admin.standListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->standService->getAllDataSource());

        $grid->addColumnText('name', $translator->translate('column_name'));
        $grid->addColumnText('location', $translator->translate('column_location'))
            ->setRenderer(function(Stand $stand) {
                return $stand->getLocation()->toString();
            })
        ;

        $grid->addAction('edit', $translator->translate('action_edit'), 'Stand:edit')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0')
        ;
        return $grid;
    }
}