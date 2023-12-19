<?php

namespace App\Model\Security\Role;
use Nette\Security\Role;

abstract class AbstractRole implements Role
{
    protected string $userId;
    protected string $roleId = '';
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    function getRoleId(): string
    {
        return $this->roleId;
    }

    function getUserId(): string
    {
        return $this->userId;
    }
}
