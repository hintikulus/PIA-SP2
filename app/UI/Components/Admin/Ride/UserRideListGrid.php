<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\RideQuery;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class UserRideListGrid extends BaseComponent
{
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;
    private User $user;

    public function __construct(
        QueryBuilderManager $queryBuilderManager,
        Translator          $translator,
        User                $user,
    )
    {
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
        $this->user = $user;
    }

    public function createComponentGrid(): BaseGrid
    {
        $translator = $this->translator->createPrefixedTranslator('admin.userRideListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);

        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(RideQuery::getByUser($this->user)));

        $grid->addColumnDateTime('start_timestamp', $translator->translate('column_start_timestamp'))
            ->setFormat(App::DATETIME_FORMAT)
        ;

        $grid->addColumnText('start_stand', $translator->translate('column_start_stand'), 'start_stand.name');

        $grid->addColumnDateTime('end_timestamp', $translator->translate('column_end_timestamp'))
            ->setFormat(App::DATETIME_FORMAT)
            ->setReplacement(['' => 'N/A'])
        ;

        $grid->addColumnText('end_stand', $translator->translate('column_end_stand'), 'end_stand.name')
            ->setReplacement(['' => 'N/A'])
        ;

        $grid->addAction('detail', $translator->translate('action_detail'), ':Admin:Ride:detail')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0');

        return $grid;
    }
}