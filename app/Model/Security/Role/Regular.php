<?php

namespace App\Model\Security\Role;


use App\Domain\User\User;

class Regular extends AbstractRole
{
    public const ROLE_ID = User::ROLE_REGULAR;
    protected string $roleId = self::ROLE_ID;
}
