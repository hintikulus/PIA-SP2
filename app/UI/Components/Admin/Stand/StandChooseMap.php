<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;

class StandChooseMap extends BaseComponent
{
    private ?Stand $stand;

    public function __construct(
        ?Stand $stand = null,
    )
    {
        $this->stand = $stand;
    }

    public function createComponentMap(): BaseMap
    {
        $map = new BaseMap();

        if ($this->stand)
        {
            $map->addMarker($this->stand->getLocation(), $this->stand->getName(), 'stand');
            $map->setView($this->stand->getLocation(), 17);
        }

        return $map;
    }
}