<?php

namespace App\Domain\Bike;

use App\Domain\Stand\Stand;
use App\Model\App;
use App\Model\Database\Query\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use PHPStan\Type\Doctrine\Descriptors\DateImmutableType;

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

    public static function getDueForService(): self
    {
        $self = self::getAll();

        $self->ons[] = function(QueryBuilder $qb): QueryBuilder {
            $qb->where('b.lastServiceTimestamp < :datetime');
            $qb->setParameter('datetime', (new \DateTime())->modify('- 6 months'));
            return $qb;
        };

        return $self;
    }

    public static function getRideable(): self
    {
        $self = self::getAll();
        $now = new \DateTime();
        $serviceTime = $now->modify('-' . App::SERVICE_TIME);


        $self->ons[] = function(Querybuilder $qb) use ($serviceTime): QueryBuilder
        {
            $qb->where('b.lastServiceTimestamp > :service_time');
            $qb->setParameter('service_time', $serviceTime);
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
