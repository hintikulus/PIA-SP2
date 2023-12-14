<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\User\User;

interface UserRideListGridFactory
{
    public function create(User $user): UserRideListGrid;
}