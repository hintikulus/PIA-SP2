<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;
use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

class BikeQuery extends AbstractQuery
{
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    public function setup(): void
    {
        $this->ons[] = function(QueryBuilder $qb): QueryBuilder {
            $qb->select('b')
                ->from(Bike::class, 's')
            ;

            return $qb;
        };
    }

}