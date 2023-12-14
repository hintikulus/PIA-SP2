<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Database\QueryManager;

class DefaultBikeFacade implements BikeFacade
{
    private EntityManagerDecorator $em;
    private QueryManager $queryManager;

    public function __construct(
        EntityManagerDecorator $entityManagerDecorator,
        QueryManager $queryManager,
    )
    {
        $this->em = $entityManagerDecorator;
        $this->queryManager = $queryManager;
    }

    public function get(string $id): ?Bike
    {
        return $this->em->getBikeRepository()->find($id);
    }

    public function save(?Bike $bike, ?string $stand_id, ?\DateTime $last_service_datetime): Bike
    {
        if ($bike === null && $stand_id === null)
        {
            throw new \Exception('Stand not found');
        }

        $this->em->beginTransaction();

        if ($stand_id !== null)
        {
            $stand = $this->em->getStandRepository()->find($stand_id);

            if ($stand === null)
            {
                $this->em->rollback();
                throw new \Exception('Stand not found');
            }

            if ($bike === null)
            {
                $bike = new Bike($stand);
                $this->em->persist($bike);
            }

            $bike->setStand($stand);
        }
        else
        {
            $bike->setStand(null);
        }

        if ($last_service_datetime !== null)
        {
            $bike->setLastServiceTimestamp($last_service_datetime);
        }

        $this->em->flush($bike);
        $this->em->commit();
        return $bike;
    }

    /**
     * @return array<Bike>
     */
    public function getAll(): array
    {
        return $this->em->getBikeRepository()->findAll();
    }

    public function makeService(Bike $bike): void
    {
        $bike->setLastServiceTimestamp(new \DateTime());
        $this->em->flush($bike);
    }

    public function getRideableBikes(): array
    {
        return $this->queryManager->findAll(BikeQuery::getRideable());
    }

    public function updateLocation(Bike $bike, Location $location): void
    {
        $bike->setLocation($location);
        $this->em->flush($bike);
    }
}
