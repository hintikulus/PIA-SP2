<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\RideQuery;
use App\Domain\Ride\RideService;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class UserRideListGrid extends BaseComponent
{
    private RideService $rideService;
    private Translator $translator;
    private User $user;

    public function __construct(
        RideService $rideService,
        Translator  $translator,
        User        $user,
    )
    {
        $this->rideService = $rideService;
        $this->translator = $translator;
        $this->user = $user;
    }

    public function createComponentGrid(): BaseGrid
    {
        $translator = $this->translator->createPrefixedTranslator('admin.userRideListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);

        $grid->setDataSource($this->rideService->getUserRidesDataSource($this->user));

        $grid->addColumnDateTime('start_timestamp', $translator->translate('column_start_timestamp'), 'startTimestamp')
            ->setFormat(App::DATETIME_FORMAT)
            ->setSortable()
        ;

        $grid->addColumnText('start_stand', $translator->translate('column_start_stand'), 'start_stand.name');

        $grid->addColumnDateTime('end_timestamp', $translator->translate('column_end_timestamp'), 'endTimestamp')
            ->setFormat(App::DATETIME_FORMAT)
            ->setReplacement(['' => 'N/A'])
            ->setSortable()
        ;;

        $grid->addColumnText('end_stand', $translator->translate('column_end_stand'), 'end_stand.name')
            ->setReplacement(['' => 'N/A'])
        ;

        $grid->addAction('detail', $translator->translate('action_detail'), ':Admin:Ride:detail')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0')
        ;

        $grid->setDefaultSort(['start_timestamp' => 'DESC']);

        return $grid;
    }
}
