<?php

namespace App\Domain\User;

use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Logic\UserNotFoundException;
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
        $user = new User($data['name'], $data['email']);
        $user->setPasswordHash($data['password']);

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
        if ($user !== null)
        {
            $this->em->rollback();
            throw new UserNotFoundException($email);
        }

        $user = new User($name, $email, $this->passwords->hash($password));

        $this->em->persist($user);
        $this->em->flush($user);
        $this->em->commit();

        return $user;
    }

    public function getByGoogleId(string $googleId): ?User
    {
        return $this->em->getUserRepository()->findOneBy(['googleId' => $googleId]);
    }

    public function createUserWithGoogle(string $name, string $email, string $googleId): ?User
    {
        $this->em->beginTransaction();

        $user = $this->getByGoogleId($googleId);
        if ($user !== null)
        {
            throw new UserNotFoundException($googleId);
        }

        $user = $this->getByEmail($email);
        if ($user !== null)
        {
            throw new UserNotFoundException($email);
        }

        $user = new User($name, $email);
        $user->setGoogleId($googleId);

        $this->em->persist($user);
        $this->em->flush($user);
        $this->em->commit();

        return $user;
    }

    public function saveUser(?User $user, string $name, ?string $password, string $email, string $role): User
    {
        $this->em->beginTransaction();

        $userTmp = $this->em->getUserRepository()->findOneByEmail($email);

        if ($userTmp !== null && $userTmp !== $user)
        {
            $this->em->rollback();
            throw new UserNotFoundException();
        }

        if ($user === null)
        {
            $user = new User($name, $email);
            if($password !== null)
            {
                $user->setPasswordHash($this->passwords->hash($password));
            }
            $user->setRole($role);
            $this->em->persist($user);
        }
        else
        {
            $user->setName($name);
            $user->setEmailAddress($email);
            if($password !== null)
            {
                $user->setPasswordHash($this->passwords->hash($password));
            }
            $user->setRole($role);
        }

        $this->em->flush($user);
        $this->em->commit();

        return $user;
    }

    public function updateLastLoginDatetime(User $user): void
    {
        $user->updateLastLogin();
        $this->em->flush($user);
    }
}
