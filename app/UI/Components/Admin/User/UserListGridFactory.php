<?php

namespace App\UI\Components\Admin\User;

interface UserListGridFactory
{
    public function create(): UserListGrid;
}