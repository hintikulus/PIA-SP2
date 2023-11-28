<?php declare(strict_types = 1);

namespace App\Model\Database\Query;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractQuery implements Queryable
{

	/** @var array<(callable(QueryBuilder):QueryBuilder)> */
	protected array $ons = [];

	public abstract function setup(): void;

	public function doQuery(EntityManagerInterface $em): Query
	{
		$qb = $this->getQueryBuilder($em);
		return $qb->getQuery();
	}

    public function getQueryBuilder(EntityManagerInterface $em): QueryBuilder
    {
        $qb = $em->createQueryBuilder();
        $this->setup();
        $this->ons = array_reverse($this->ons);

        foreach ($this->ons as $on)
        {
            $qb = $on($qb);
        }

        return $qb;
    }

}
