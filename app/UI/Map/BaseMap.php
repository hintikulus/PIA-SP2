<?php

namespace App\UI\Map;

use App\Domain\Location\Location;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\ComponentModel\IComponent;

class BaseMap extends Map
{
    public function __construct()
    {
        parent::__construct();
        $this->setView(new Location(49.7474242, 13.3773194), 12);
        $this->setZoomRange(12, 19);

        $this->monitor(
            Presenter::class,
            function(Presenter $presenter): void {
                $this->addMarkerType('stand')
                    ->setIcon($this->presenter->template->basePath . '/assets/base/img/map/marker/bike_stand.png', [48, 48], [24, 46]);
            }
        );
    }
}