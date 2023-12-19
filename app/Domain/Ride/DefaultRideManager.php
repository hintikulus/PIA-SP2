<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Config\ConfigManager;
use App\Domain\User\User;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Logic\RideNotFoundException;
use PHP_CodeSniffer\Config;
use Ramsey\Uuid\Uuid;

class DefaultRideManager implements RideManager
{

    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em,
    )
    {
        $this->em = $em;
    }

    public function getById(string $id): Ride
    {
        $stand = $this->findById($id);

        if ($stand === null)
        {
            throw new RideNotFoundException($id);
        }

        return $stand;
    }

    public function findById(string $id): ?Ride
    {
        if (!Uuid::isValid($id))
        {
            return null;
        }

        return $this->em->getRideRepository()->find($id);
    }

    public function save(Ride $ride): void
    {
        $this->em->flush($ride);
        $this->em->flush($ride->getBike());
    }

    public function findActiveByUser(User $user): ?Ride
    {
        return $this->em->getRideRepository()->findOneBy(['user' => $user, 'state' => Ride::STATE_STARTED]);
    }

    public function startRide(User $user, Bike $bike, \DateInterval $serviceInterval): Ride
    {
        $ride = $bike->startRide($user, $serviceInterval);
        $this->em->persist($ride);
        return $ride;
    }
}