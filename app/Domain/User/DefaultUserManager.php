<?php

namespace App\Domain\User;

use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Logic\UserNotFoundException;
use App\Model\Security\Passwords;
use Ramsey\Uuid\Uuid;

class DefaultUserManager implements UserManager
{
    private EntityManagerDecorator $em;
    private Passwords $passwords;

    public function __construct(
        EntityManagerDecorator $em,
        Passwords $passwords,
    )
    {
        $this->em = $em;
        $this->passwords = $passwords;
    }

    public function getById(string $id): User
    {
        $user = $this->findById($id);

        if($user === null)
        {
            throw new UserNotFoundException($id);
        }

        return $user;
    }

    public function findById(string $id): ?User
    {
        if(!Uuid::isValid($id))
        {
            return null;
        }

        return $this->em->getUserRepository()->find($id);
    }

    public function save(User $user) : void
    {
        $this->em->flush($user);
    }

    public function getByEmail(string $email): User
    {
        $user = $this->findByEmail($email);

        if($user === null)
        {
            throw new UserNotFoundException($email);
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->em->getUserRepository()->findOneByEmail($email);
    }

    public function getByGoogleId(string $googleId): User
    {
        $user = $this->findByGoogleId($googleId);

        if($user === null)
        {
            throw new UserNotFoundException($googleId);
        }

        return $user;
    }

    public function findByGoogleId(string $googleId): ?User
    {
        return $this->em->getUserRepository()->findOneBy(['googleId' => $googleId]);
    }

    public function createUser(string $name, string $email, #[\SensitiveParameter] ?string $password, array $data = []): User
    {
        $user = new User($name, $email);

        if($password !== null)
        {
            $user->setPasswordHash($this->passwords->hash($password));
        }

        if(isset($data['google_id']))
        {
            $user->setGoogleId($data['google_id']);
        }

        $this->em->persist($user);
        return $user;
    }

    public function updateUser(User $user, string $name, #[\SensitiveParameter] ?string $password, string $role, array $data = []): void
    {
        $user->setName($name);

        if($password !== null)
        {
            $user->setPasswordHash($this->passwords->hash($password));
        }

        $user->setRole($role);

        if(isset($data['google_id']))
        {
            $user->setGoogleId($data['google_id']);
        }
    }
}