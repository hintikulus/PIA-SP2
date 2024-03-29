<?php declare(strict_types = 1);

namespace App\Domain\User;

use App\Model\Database\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method User|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method User|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{

	public function findOneByEmail(string $email): ?User
	{
		return $this->findOneBy(['emailAddress' => $email]);
	}

    public function getAllQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('u');
        return $qb;
    }

}
