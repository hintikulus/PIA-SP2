<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\BikeFacade;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;

class BikeListMap extends BaseComponent
{
    private BikeFacade $bikeFacade;

    public function __construct(
        BikeFacade $bikeFacade,
    )
    {
        $this->bikeFacade = $bikeFacade;
    }

    public function createComponentMap(): BaseMap
    {
        $map = new BaseMap();

        foreach ($this->bikeFacade->getAll() as $bike)
        {
            $markerType = '';
            if(!$bike->isInStand())
            {
                $markerType = 'bike_ride';
            } else if($bike->isDueForService())
            {
                $markerType = 'bike_service';
            } else {
                $markerType = 'bike';
            }

            $map->addMarker($bike->getLocation(), 'Kolo', $markerType);
        }

        return $map;
    }
}