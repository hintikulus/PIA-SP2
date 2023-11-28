<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\Bike;

interface BikeFormFactory
{
    public function create(?Bike $bike = null, ?string $cancelUrl = null): BikeForm;
}