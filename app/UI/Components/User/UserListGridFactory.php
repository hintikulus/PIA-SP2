<?php

namespace App\UI\Components\User;

interface UserListGridFactory
{
    public function create(): UserListGrid;
}