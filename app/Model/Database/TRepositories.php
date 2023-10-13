<?php

namespace App\Model\Database;

use App\Domain\User\User;
use App\Domain\User\UserRepository;

/**
 * @mixin EntityManagerDecorator
 */
trait TRepositories
{
    public function getUserRepository(): UserRepository
    {
        return $this->getRepository(User::class);
    }
}