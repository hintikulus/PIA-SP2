<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\UI\Map\BaseMap;

interface StandChooseMapFactory
{
    public function create(?Stand $stand = null): StandChooseMap;
}