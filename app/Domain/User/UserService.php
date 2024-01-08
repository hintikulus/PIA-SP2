<?php

namespace App\Domain\User;

use App\Model\Exception\Logic\UserNotFoundException;

interface UserService
{
    /**
     * Retrieves a user entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the user.
     * @return User The user entity.
     * @throws UserNotFoundException When the user with the given ID is not found.
     */
    public function getById(string $id): User;

    /**
     * Finds a user entity from the service layer based on the provided ID.
     *
     * @param string $id The unique identifier of the user.
     * @return User|null The user entity if found, or null if the user is not found.
     */
    public function findById(string $id): ?User;

    /**
     * Retrieves a user entity from the service layer based on the provided email.
     *
     * @param string $email The email address of the user.
     * @return User The user entity.
     * @throws UserNotFoundException When the user with the given email is not found.
     */
    public function getByEmail(string $email): User;

    /**
     * Finds a user entity from the service layer based on the provided email.
     *
     * @param string $email The email address of the user.
     * @return User|null The user entity if found, or null if the user with the given email is not found.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Retrieves a user entity from the service layer based on the provided Google ID.
     *
     * @param string $googleId The Google ID of the user.
     * @return User The user entity.
     * @throws UserNotFoundException When the user with the given Google ID is not found.
     */
    public function getByGoogleId(string $googleId): User;

    /**
     * Finds a user entity from the service layer based on the provided Google ID.
     *
     * @param string $googleId The Google ID of the user.
     * @return User|null The user entity if found, or null if the user with the given Google ID is not found.
     */
    public function findByGoogleId(string $googleId): ?User;

    /**
     * Retrieves an array of all users.
     *
     * @return array<User> An array containing all available user entities.
     */
    public function getAll(): array;

    /**
     * Retrieves the data source for all users.
     *
     * @return mixed The data source for all users.
     */
    public function getAllDataSource(): mixed;

    /**
     * Creates a new user entity with the given information.
     *
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     * @param array $data Additional data for user creation.
     * @return User The newly created user entity.
     */
    public function createUser(string $name, string $email, string $password, array $data = []): User;

    /**
     * Updates an existing user entity with the given information.
     *
     * @param User $user The user entity to update.
     * @param string $name The new name of the user.
     * @param string|null $password The new password of the user (nullable for no password change).
     * @param string $role The new role of the user.
     * @param array $data Additional data for user update.
     */
    public function updateUser(User $user, string $name, ?string $password, string $role, array $data = []): void;

    /**
     * Updates the last login datetime for the specified user.
     *
     * @param User $user The user entity for whom to update the last login datetime.
     */
    public function updateLastLoginDatetime(User $user): void;
}