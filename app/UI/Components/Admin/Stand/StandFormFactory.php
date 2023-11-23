<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\Stand;
use App\UI\Form\BaseForm;

interface StandFormFactory
{
    public function create(?Stand $stand = null, string $cancelUrl = null): StandForm;
}