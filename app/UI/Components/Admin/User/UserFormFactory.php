<?php

namespace App\UI\Components\Admin\User;

use App\Domain\User\User;

interface UserFormFactory
{
    public function create(?User $user = null, string $cancelUrl = null): UserForm;
}