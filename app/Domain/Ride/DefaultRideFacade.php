<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\LogicException;

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

    public function startRide(User $user, Bike $bike): Ride
    {
        $this->em->beginTransaction();

        try
        {
            $ride = $bike->startRide($user);
        }
        catch (\Exception $e)
        {
            $this->em->rollback();
            throw $e;
        }

        $this->em->persist($ride);
        $this->em->flush();
        $this->em->commit();

        return $ride;
    }

    public function isUserInRide(User $user): bool
    {
        return $this->getUsersActiveRide($user) !== null;
    }

    public function getUsersActiveRide(User $user): ?Ride
    {
        return $this->em->getRideRepository()->findOneBy(['user' => $user, 'state' => Ride::STATE_STARTED]);
    }

    public function endRide(Ride $ride, Stand $stand): void
    {
        if ($ride->getState() !== Ride::STATE_STARTED)
        {
            throw new LogicException('Bad State');
        }

        $distance = $ride->getBike()->getLocation()->distance($stand->getLocation());

        if ($distance > App::BIKE_DISTANCE_DELIVERY)
        {
            throw new LogicException('Bike is too far');
        }

        $ride->complete($stand);
        $this->em->flush();
    }
}
