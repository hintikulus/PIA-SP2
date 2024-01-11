<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;
use App\Model\App;
use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use PHPStan\Type\Doctrine\Descriptors\DateImmutableType;

/**
 * Represents a query builder for querying Bike entities.
 */
class BikeQuery extends AbstractQuery
{
    /**
     * Gets a query builder for retrieving all Bike entities with associated Stand information.
     *
     * @return self The BikeQuery instance for retrieving all Bike entities.
     */
    public static function getAll(): self
    {
        $self = new self();
        $self->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->addSelect('s');
            $qb->leftJoin('b.stand', 's');
            return $qb;
        };

        return $self;
    }

    /**
     * Gets a query builder for retrieving Bike entities due for service.
     *
     * @return self The BikeQuery instance for retrieving Bike entities due for service.
     */
    public static function getDueForService(): self
    {
        $self = self::getAll();

        $self->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->where('b.lastServiceTimestamp < :datetime');
            $qb->setParameter('datetime', (new \DateTime())->modify('- ' . App::SERVICE_TIME));
            $qb->andWhere('b.stand IS NOT NULL');
            return $qb;
        };

        return $self;
    }

    /**
     * Gets a query builder for retrieving rideable Bike entities.
     *
     * @return self The BikeQuery instance for retrieving rideable Bike entities.
     */
    public static function getRideable(): self
    {
        $self = self::getAll();
        $now = new \DateTime();
        $serviceTime = $now->modify('-' . App::SERVICE_TIME);

        $self->ons[] = function (QueryBuilder $qb) use ($serviceTime): QueryBuilder {
            $qb->where('b.lastServiceTimestamp > :service_time');
            $qb->setParameter('service_time', $serviceTime);
            return $qb;
        };

        return $self;
    }

    /**
     * Sets up the query builder to select Bike entities.
     */
    public function setup(): void
    {
        $this->ons[] = function (QueryBuilder $qb): QueryBuilder {
            $qb->select('b')
                ->from(Bike::class, 'b');

            return $qb;
        };
    }
}
