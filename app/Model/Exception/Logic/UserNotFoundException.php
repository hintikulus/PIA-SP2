<?php

namespace App\Model\Exception\Logic;

use App\Model\Exception\LogicException;

class UserNotFoundException extends LogicException
{
    public readonly string $userId;

    public function __construct(string $userId)
    {
        parent::__construct("User {$userId} was not found.", 404);
        $this->userId = $userId;
    }

}
