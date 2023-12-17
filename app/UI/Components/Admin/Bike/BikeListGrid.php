<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeService;
use App\Model\App;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class BikeListGrid extends BaseComponent
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
        $translator = $this->translator->createPrefixedTranslator('admin.bikeListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->bikeService->getAllBikesDataSource());

        $grid->addColumnText('stand', $translator->translate('column_stand'), 'stand.name');

        $grid->addColumnDateTime('last_service_datetime', $translator->translate('column_last_service_datetime'), 'last_service_timestamp')
            ->setFormat(App::DATETIME_FORMAT)
        ;

        $grid->addColumnDateTime('next_service_datetime', $translator->translate('column_next_service_datetime'), 'last_service_timestamp')
            ->setRenderer(function(Bike $bike) {
                return $bike->getNextServiceDatetime()->format(App::DATETIME_FORMAT);
            })
        ;

        $grid->addColumnText('status', $translator->translate('column_status'))->setRenderer(function(Bike $bike) {

            $iconClass = '';
            $colorClass = '';

            if (!$bike->isInStand())
            {
                $iconClass = 'fas fa-person-biking';
                $colorClass = 'btn-outline-success';
            }
            else if (!$bike->isDueForService())
            {
                $iconClass = 'fas fa-parking';
                $colorClass = 'btn-outline-primary';
            }
            else
            {
                $iconClass = 'fas fa-cog';
                $colorClass = 'btn-outline-warning';
            }

            return Html::el('span', ['class' => 'btn btn-icon-only btn-rounded mb-0 btn-sm d-flex align-items-center justify-content-center p-3 ' . $colorClass])
                ->addHtml(Html::el('i', ['class' => $iconClass . ' text-lg']))
            ;
        })
            ->setAlign('center')
            ->setFitContent()
        ;

        $grid->addAction('edit', $translator->translate('action_edit'), 'Bike:edit')
            ->setClass('btn btn-sm bg-gradient-secondary mb-0')
        ;

        return $grid;
    }
}
