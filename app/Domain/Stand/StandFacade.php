<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Database\EntityManagerDecorator;
use Doctrine\ORM\QueryBuilder;

class StandFacade
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em,
    )
    {
        $this->em = $em;
    }

    public function getAllQueryBuilder(): QueryBuilder
    {
        return $this->em
            ->getStandRepository()
            ->getAllQueryBuilder();

    }

    public function getAll(): array
    {
        return $this->em->getStandRepository()->findAll();
    }
}