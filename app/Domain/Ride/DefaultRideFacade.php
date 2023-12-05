<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\Database\EntityManagerDecorator;

class DefaultRideFacade implements RideFacade
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em,
    )
    {
        $this->em = $em;
    }

    public function get(string $id): ?Ride
    {
        return $this->em->getRideRepository()->find($id);
    }

    public function startRide(User $user, Bike $bike, Stand $startStand): Ride
    {
        $this->em->beginTransaction();

        $ride = new Ride($user, $bike, $startStand);
        $this->em->persist($ride);
        $this->em->flush($ride);

        $this->em->commit();

        return $ride;
    }
}
