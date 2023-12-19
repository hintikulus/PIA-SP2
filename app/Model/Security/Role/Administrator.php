<?php

namespace App\Model\Security\Role;


use App\Domain\User\User;

class Administrator extends AbstractRole
{
    public const ROLE_ID = User::ROLE_ADMIN;
    protected string $roleId = self::ROLE_ID;
}
