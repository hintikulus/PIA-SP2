<?php

namespace App\Domain\User;

use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use Psr\Log\LoggerInterface;

class DefaultUserService implements UserService
{
    private UserManager $userManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;
    private LoggerInterface $logger;

    public function __construct(
        UserManager $userManager,
        QueryManager $queryManager,
        QueryBuilderManager $queryBuilderManager,
        LoggerInterface $logger,
    )
    {
        $this->userManager = $userManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->logger = $logger;
    }

    public function getById(string $id): User
    {
        $this->logger->info("Getting User by id $id");
        return $this->userManager->getById($id);
    }

    public function findById(string $id): ?User
    {
        $this->logger->info("Finding User by id $id");
        return $this->userManager->findById($id);
    }

    public function getByEmail(string $email): User
    {
        $this->logger->info("Getting User by email $email");
        return $this->userManager->getByEmail($email);
    }

    public function findByEmail(string $email): ?User
    {
        $this->logger->info("Finding User by email $email");
        return $this->userManager->findByEmail($email);
    }

    public function getByGoogleId(string $googleId): User
    {
        $this->logger->info("Getting User by GoogleID $googleId");
        return $this->userManager->getByGoogleId($googleId);
    }

    public function findByGoogleId(string $googleId): ?User
    {
        $this->logger->info("Finding User by GoogleID $googleId");
        return $this->userManager->findByGoogleId($googleId);
    }

    public function getAll(): array
    {
        $this->logger->info("Getting all users");
        return $this->queryManager->findAll(UserQuery::getAll());
    }

    public function getAllDataSource(): mixed
    {
        $this->logger->info("Getting all users data source");
        return $this->queryBuilderManager->getQueryBuilder(UserQuery::getAll());
    }

    public function createUser(string $name, string $email, #[\SensitiveParameter] ?string $password, array $data = []): User
    {
        $this->logger->info("Creating user with name $name and email $email");
        $user = $this->userManager->createUser($name, $email, $password, $data);

        $this->logger->debug("User $user created, saving it");
        $this->userManager->save($user);
        return $user;
    }

    public function updateUser(User $user, string $name, #[\SensitiveParameter] ?string $password, string $role, array $data = []): void
    {
        $this->logger->info("Updating user $user");
        $this->userManager->updateUser($user, $name, $password, $role, $data);

        $this->logger->debug("User $user updated, saving it");
        $this->userManager->save($user);
    }

    public function updateLastLoginDatetime(User $user): void
    {
        $this->logger->info("Updating $user last login timestamp");
        $user->updateLastLogin();

        $this->logger->debug("User's $user last login timestamp updated, saving it");
        $this->userManager->save($user);
    }
}