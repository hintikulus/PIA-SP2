<?php

namespace App\Domain\Stand;

use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

class StandQuery extends AbstractQuery
{
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    public function setup(): void
    {
        $this->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->select('s')
                ->from(Stand::class, 's');

            return $qb;
        };
    }
}