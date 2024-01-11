<?php

namespace App\Domain\Stand;

use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
/**
 * Represents a query builder for querying Stand entities.
 */
class StandQuery extends AbstractQuery
{
    /**
     * Gets a query builder for retrieving all Stand entities.
     *
     * @return self The StandQuery instance for retrieving all Stand entities.
     */
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    /**
     * Sets up the query builder to select Stand entities.
     */
    public function setup(): void
    {
        $this->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->select('s')
                ->from(Stand::class, 's');

            return $qb;
        };
    }
}
