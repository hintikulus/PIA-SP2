<?php

namespace App\Domain\Ride;

use App\Domain\User\User;
use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

class RideQuery extends AbstractQuery
{
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    public static function getByUser(User $user): self
    {
        $self = self::getAll();
        $self->ons[] = function(QueryBuilder $qb) use ($user): QueryBuilder {
            $qb->andWhere('r.user = :user')
                ->setParameter('user', $user->getId()->getBytes())
            ;

            return $qb;
        };

        return $self;
    }

    public function setup(): void
    {
        $this->ons[] = function(QueryBuilder $qb): QueryBuilder {
            $qb->select('r')
                ->from(Ride::class, 'r')
            ;

            return $qb;
        };
    }
}