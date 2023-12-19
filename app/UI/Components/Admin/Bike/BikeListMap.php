<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\BikeService;
use App\Domain\Config\ConfigService;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;

class BikeListMap extends BaseComponent
{
    private BikeService $bikeService;
    private ConfigService $configService;

    public function __construct(
        BikeService $bikeService,
        ConfigService $configService,
    )
    {
        $this->bikeService = $bikeService;
        $this->configService = $configService;
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
            } else if($bike->isDueForService($this->configService->getBikeServiceInterval()))
            {
                $markerType = 'bike_service';
            } else {
                $markerType = 'bike';
            }

            $map->addMarker($bike->getLocation(), $bike->getId()->toString(), $markerType, 'bike');
        }

        return $map;
    }
}
