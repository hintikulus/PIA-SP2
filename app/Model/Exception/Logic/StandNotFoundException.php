<?php

namespace App\Model\Exception\Logic;

use App\Model\Exception\LogicException;

class StandNotFoundException extends LogicException
{
    public readonly string $standId;

    public function __construct(string $standId)
    {
        parent::__construct("Stand {$standId} was not found.", 404);
        $this->standId = $standId;
    }

}
