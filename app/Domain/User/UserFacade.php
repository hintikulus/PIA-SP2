<?php

namespace App\Domain\User;

use App\Domain\Ride\Ride;

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
     * Method returns user of given Google identifier
     * @param string $googleId
     * @return User|null
     */
    public function getByGoogleId(string $googleId): ?User;

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


    public function createUserWithGoogle(string $name, string $email, string $googleId): ?User;

    public function saveUser(?User $user, string $name, ?string $password, string $email, string $role): User;

    public function updateLastLoginDatetime(User $user): void;
}
