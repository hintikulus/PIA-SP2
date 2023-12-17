<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Logic\BikeNotFoundException;
use Ramsey\Uuid\Uuid;

class DefaultBikeManager implements BikeManager
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em
    )
    {
        $this->em = $em;
    }

    public function getById(string $id): Bike
    {
        $bike = $this->findById($id);

        if($bike === null)
        {
            throw new BikeNotFoundException($id);
        }

        return $bike;
    }

    public function findById(string $id): ?Bike
    {
        if(!Uuid::isValid($id))
        {
            return null;
        }

        return $this->em->getBikeRepository()->find($id);

    }

    public function save(Bike $bike): void
    {
        $this->em->flush($bike);
    }

    public function createBike(Stand $stand): Bike
    {
        $bike = new Bike($stand);
        $this->em->persist($bike);

        return $bike;
    }

    public function updateBike(Bike $bike, ?Stand $stand, \DateTime $lastServiceDatetime)
    {
        if($stand)
        {
            $bike->setStand($stand);
        }

        $bike->setLastServiceTimestamp($lastServiceDatetime);
    }
}