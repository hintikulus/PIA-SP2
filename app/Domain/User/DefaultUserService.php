<?php

namespace App\Domain\User;

use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;

class DefaultUserService implements UserService
{
    private UserManager $userManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;

    public function __construct(
        UserManager $userManager,
        QueryManager $queryManager,
        QueryBuilderManager $queryBuilderManager,
    )
    {
        $this->userManager = $userManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
    }

    public function getById(string $id): User
    {
        return $this->userManager->getById($id);
    }

    public function findById(string $id): ?User
    {
        return $this->userManager->findById($id);
    }

    public function getByEmail(string $email): User
    {
        return $this->userManager->getByEmail($email);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userManager->findByEmail($email);
    }

    public function getByGoogleId(string $googleId): User
    {
        return $this->userManager->getByGoogleId($googleId);
    }

    public function findByGoogleId(string $googleId): ?User
    {
        return $this->userManager->findByGoogleId($googleId);
    }

    public function getAll(): array
    {
        return $this->queryManager->findAll(UserQuery::getAll());
    }

    public function getAllDataSource(): mixed
    {
        return $this->queryBuilderManager->getQueryBuilder(UserQuery::getAll());
    }

    public function createUser(string $name, string $email, #[\SensitiveParameter] ?string $password, array $data = []): User
    {
        $user = $this->userManager->createUser($name, $email, $password, $data);

        $this->userManager->save($user);
        return $user;
    }

    public function updateUser(User $user, string $name, #[\SensitiveParameter] ?string $password, string $role, array $data = []): void
    {
        $this->userManager->updateUser($user, $name, $password, $role, $data);
        $this->userManager->save($user);
    }

    public function updateLastLoginDatetime(User $user): void
    {
        $user->updateLastLogin();
        $this->userManager->save($user);
    }
}