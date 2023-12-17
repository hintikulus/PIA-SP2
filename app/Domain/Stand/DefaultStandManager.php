<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Logic\StandNotFoundException;
use Ramsey\Uuid\Uuid;

class DefaultStandManager implements StandManager
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em,
    )
    {
        $this->em = $em;
    }

    public function getById(string $id): Stand
    {
        $stand = $this->findById($id);

        if($stand === null)
        {
            throw new StandNotFoundException($id);
        }

        return $stand;
    }

    public function findById(string $id): ?Stand
    {
        if(!Uuid::isValid($id))
        {
            return null;
        }

        return $this->em->getStandRepository()->find($id);
    }

    public function createStand(string $name, Location $location): Stand
    {
        $stand = new Stand($name, $location);
        $this->em->persist($stand);

        return $stand;
    }

    public function updateStand(Stand $stand, string $name, Location $location): void
    {
        $stand->setName($name);
        $stand->setLocation($location);
    }

    public function save(Stand $stand): void
    {
        $this->em->flush($stand);
    }
}