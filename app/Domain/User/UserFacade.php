<?php

namespace App\Domain\User;

interface UserFacade
{
    /**
     * Method fetch User entity of given identifier
     * @param string $id
     * @return User|null
     */
    public function get(string $id): ?User;

    /**
     * Method returns all fetched User entities in array
     * @return array<User>
     */
    public function getAll(): array;

    /**
     * Creates user entity from given data array
     * @param array<mixed> $data
     * @return User
     */
    public function createUserFromArray(array $data): User;

    public function createUser(string $name, string $email, string $password): User;
}
