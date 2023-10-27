<?php

namespace App\Domain\Stand;

use App\Domain\User\User;
use App\Model\Database\Repository\AbstractRepository;

/**
 * @method Stand|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Stand|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Stand[] findAll()
 * @method Stand[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Stand>
 */
class StandRepository extends AbstractRepository
{


    public function getAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('u');
        return $qb;
    }
}