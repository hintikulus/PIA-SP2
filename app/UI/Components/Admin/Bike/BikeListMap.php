<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\BikeService;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;

class BikeListMap extends BaseComponent
{
    private BikeService $bikeService;

    public function __construct(
        BikeService $bikeService,
    )
    {
        $this->bikeService = $bikeService;
    }

    public function createComponentMap(): BaseMap
    {
        $map = new BaseMap();

        foreach ($this->bikeService->getAllBikes() as $bike)
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