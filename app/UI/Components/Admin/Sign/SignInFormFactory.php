<?php

namespace App\UI\Components\Admin\Sign;

interface SignInFormFactory
{
    public function create(): SignInForm;
}