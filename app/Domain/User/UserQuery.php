<?php declare(strict_types = 1);

namespace App\Domain\User;

use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

/**
 * Represents a query builder for querying User entities.
 */
class UserQuery extends AbstractQuery
{
    /**
     * Gets a query builder for retrieving all User entities.
     *
     * @return self The UserQuery instance for retrieving all User entities.
     */
    public static function getAll(): self
    {
        $self = new self();
        return $self;
    }

    /**
     * Gets a query builder for retrieving User entities with a specific email address.
     *
     * @param string $email The email address to match.
     * @return self The UserQuery instance for retrieving User entities by email address.
     */
    public static function ofEmail(string $email): self
    {
        $self = new self();
        $self->ons[] = function (QueryBuilder $qb) use ($email): QueryBuilder {
            $qb->andWhere('u.emailAddress = :emailAddress')
                ->setParameter('emailAddress', $email);

            return $qb;
        };

        return $self;
    }

    /**
     * Sets up the query builder to select User entities.
     */
    public function setup(): void
    {
        $this->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->select('u')
                ->from(User::class, 'u');

            return $qb;
        };
    }
}

