<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Stand\StandFacade;
use App\UI\Components\Base\BaseComponent;

class StandListMap extends BaseComponent
{
    private StandFacade $standFacade;

    public function __construct(
        StandFacade $standFacade,
    )
    {
        $this->standFacade = $standFacade;
    }

    public function render(mixed $params = null): void
    {
        $this->template->stands = $this->standFacade->getAll();
        parent::render($params);
    }
}