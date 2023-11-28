<?php

namespace App\Domain\Bike;

use App\Domain\Bike\Bike;
use App\Model\Database\Repository\AbstractRepository;

/**
 * @method Bike|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Bike|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Bike[] findAll()
 * @method Bike[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Bike>
 */
class BikeRepository extends AbstractRepository
{

}