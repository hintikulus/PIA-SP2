<?php

namespace App\Model\Database;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeRepository;
use App\Domain\Ride\Ride;
use App\Domain\Ride\RideRepository;
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

    public function getBikeRepository(): BikeRepository
    {
        return $this->getRepository(Bike::class);
    }

    public function getRideRepository(): RideRepository
    {
        return $this->getRepository(Ride::class);
    }
}
