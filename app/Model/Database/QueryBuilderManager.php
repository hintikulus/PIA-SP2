<?php

namespace App\Model\Database;

use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderManager
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function getQueryBuilder(AbstractQuery $query): QueryBuilder
    {
        return $query->getQueryBuilder($this->em);
    }
}
