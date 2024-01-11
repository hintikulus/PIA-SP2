<?php

namespace App\Domain\Ride;

use App\Domain\User\User;
use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

/**
 * Represents a query builder for querying Ride entities.
 */
class RideQuery extends AbstractQuery
{
    /**
     * Gets a query builder for retrieving all Ride entities.
     *
     * @return self The RideQuery instance for retrieving all Ride entities.
     */
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    /**
     * Gets a query builder for retrieving Ride entities associated with a specific user.
     *
     * @param User $user The user associated with the Ride entities to retrieve.
     * @return self The RideQuery instance for retrieving Ride entities by user.
     */
    public static function getByUser(User $user): self
    {
        $self = self::getAll();
        $self->ons[] = function (QueryBuilder $qb) use ($user): QueryBuilder {
            $qb->andWhere('r.user = :user')
                ->setParameter('user', $user->getId()->getBytes());
            $qb->select('r');

            $qb->leftJoin('r.startStand', 'ss')
                ->addSelect('ss');
            $qb->leftJoin('r.endStand', 'es')
                ->addSelect('es');

            return $qb;
        };

        return $self;
    }

    /**
     * Sets up the query builder to select Ride entities.
     */
    public function setup(): void
    {
        $this->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->select('r')
                ->from(Ride::class, 'r');

            return $qb;
        };
    }
}
