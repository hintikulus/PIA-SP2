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
        $self->ons[] = function(QueryBuilder $qb): QueryBuilder {
            $qb->addSelect('s');
            $qb->leftJoin('b.stand', 's');
            return $qb;
        };

        return $self;
    }

    public function setup(): void
    {
        $this->ons[] = function(QueryBuilder $qb): QueryBuilder {
            $qb->select('b')
                ->from(Bike::class, 'b')
            ;

            return $qb;
        };
    }

}