<?php

namespace App\Domain\Bike;

use App\Model\Database\EntityManagerDecorator;

class DefaultBikeFacade implements BikeFacade
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $entityManagerDecorator,
    )
    {
        $this->em = $entityManagerDecorator;
    }

    public function get(string $id): ?Bike
    {
        return $this->em->getBikeRepository()->find($id);
    }
}