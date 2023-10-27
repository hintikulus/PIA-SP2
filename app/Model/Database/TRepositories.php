<?php

namespace App\Model\Database;

use App\Domain\Stand\Stand;
use App\Domain\Stand\StandRepository;
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

    public function getStandRepository(): StandRepository
    {
        return $this->getRepository(Stand::class);
    }
}