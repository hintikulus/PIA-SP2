<?php

namespace App\UI\Components\Admin\Bike\DueForService;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeQuery;
use App\Domain\Stand\StandQuery;
use App\Model\Database\QueryManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Contributte\Translation\Translator;

class BikeDueForServiceListMap extends BaseComponent
{
    private QueryManager $queryManager;
    private Translator $translator;

    public function __construct(
        QueryManager $queryManager,
        Translator $translator,
    )
    {
        $this->queryManager = $queryManager;
        $this->translator = $translator;
    }

    public function createComponentMap(): BaseMap
    {
        $translator = $this->translator->createPrefixedTranslator('admin.bikeDueForServiceListMap');
        $map = new BaseMap();

        /** @var Bike $bike */
        foreach ($this->queryManager->findAll(BikeQuery::getDueForService()) as $bike)
        {
            $map->addMarker($bike->getLocation(), 'Kolo', 'bike_service');
        }

        return $map;
    }
}
