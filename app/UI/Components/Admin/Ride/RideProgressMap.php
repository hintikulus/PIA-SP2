<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Stand\StandFacade;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;

class RideProgressMap extends BaseComponent
{
    private StandFacade $standFacade;
    private Ride $ride;

    public function __construct(
        StandFacade $standFacade,
        Ride $ride,
    )
    {
        $this->standFacade = $standFacade;
        $this->ride = $ride;
    }

    public function createComponentMap(): BaseMap
    {
        $map = new BaseMap();

        $map->addMarker($this->ride->getBike()->getLocation(), 'bike', 'bike_ride', 'bike');

        foreach ($this->standFacade->getAll() as $stand)
        {
            $map->addMarker($stand->getLocation(), 'stand', $stand !== $this->ride->getStartStand() ? 'stand' : 'stand_green', 'stand');
        }


        return $map;
    }
}
