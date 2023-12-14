<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Database\EntityManagerDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LogicalOperatorSpacingSniff;

class DefaultStandFacade implements StandFacade
{
    private EntityManagerDecorator $em;

    public function __construct(
        EntityManagerDecorator $em,
    )
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getStandRepository()->findAll();
    }

    public function get(string $id): ?Stand
    {
        return $this->em->getStandRepository()->find($id);
    }

    public function save(?Stand $stand, string $name, $latitude, $longtitude): void
    {
        $location = new Location($latitude, $longtitude);

        if ($stand === null)
        {
            $stand = new Stand($name, $location);
            $this->em->persist($stand);
        }
        else
        {
            $stand->setName($name);
            $stand->setLocation($location);
        }

        $this->em->flush($stand);
    }
}
