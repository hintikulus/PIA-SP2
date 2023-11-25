<?php

namespace App\Domain\User;

use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Runtime\AuthenticationException;
use App\Model\Security\Passwords;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Mockery\Generator\StringManipulation\Pass\Pass;
use mysql_xdevapi\Exception;

class DefaultUserFacade implements UserFacade
{
    private EntityManagerDecorator $em;
    private Passwords $passwords;

    public function __construct(
        EntityManagerDecorator $em,
        Passwords              $passwords,
    )
    {
        $this->em = $em;
        $this->passwords = $passwords;
    }

    public function createUserFromArray(array $data): User
    {
        $user = new User($data['name'], $data['email'], $data['password']);

        $this->em->persist($user);
        $this->em->flush($user);
        return $user;
    }

    public function getAll(): array
    {
        return $this->em->getUserRepository()->findAll();
    }

    public function getByEmail(string $email): ?User
    {
        return $this->em->getUserRepository()->findOneByEmail($email);
    }

    public function get(string $id): ?User
    {
        return $this->em->getUserRepository()->find($id);
    }

    public function createUser(string $name, string $email, #[\SensitiveParameter] string $password): User
    {
        $this->em->beginTransaction();
        $user = $this->em->getUserRepository()->findOneByEmail($email);
        if($user !== null)
        {
            $this->em->rollback();
            throw new AuthenticationException();
        }

        $user = new User($name, $email, $this->passwords->hash($password));

        $this->em->persist($user);
        $this->em->flush($user);
        $this->em->commit();

        return $user;
    }
}
