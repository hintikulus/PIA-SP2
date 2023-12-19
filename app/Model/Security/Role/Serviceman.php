<?php

namespace App\Model\Security\Role;


use App\Domain\User\User;

class Serviceman extends AbstractRole
{
    public const ROLE_ID = User::ROLE_SERVICEMAN;
    protected string $roleId = self::ROLE_ID;
}
