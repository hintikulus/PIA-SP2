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
     * Method returns user of given email
     * @return User|null
     */
    public function getByEmail(string $email): ?User;

    /**
     * Creates user entity from given data array
     * @param array<mixed> $data
     * @return User
     */
    public function createUserFromArray(array $data): User;

    /**
     * Creates user entity with given data
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createUser(string $name, string $email, string $password): User;
}
