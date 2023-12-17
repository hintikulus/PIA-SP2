<?php

namespace App\Model\Exception\Logic;

use App\Domain\Bike\Bike;
use App\Domain\User\User;
use App\Model\Exception\LogicException;

class UserInRideException extends LogicException
{
    public readonly User $user;

    public function __construct(User $user)
    {
        parent::__construct("User {$user} can't start new ride, user is in ongoing ride");
        $this->user = $user;
    }
}