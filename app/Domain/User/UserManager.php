<?php

namespace App\Domain\User;

use App\Model\Exception\Logic\UserNotFoundException;

interface UserManager
{
    /**
     * Retrieves a user entity from the repository based on the provides ID
     *
     * @param string $id
     * @return User|null
     */
    public function findById(string $id): ?User;

    /**
     * Finds a user entity from the repository based on the provided ID
     *
     * @param string $email
     * @return User
     * @throws UserNotFoundException
     */
    public function getById(string $id): User;

    /**
     * Finds a user entity from the repository based on the provided email.
     *
     * @param string $email The email address of the user.
     * @return User The user entity.
     * @throws UserNotFoundException When the user with the given email is not found.
     */
    public function getByEmail(string $email): User;

    /**
     * Finds a user entity from the repository based on the provided email.
     *
     * @param string $email The email address of the user.
     * @return User|null The user entity if found, or null if the user with the given email is not found.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Finds a user entity from the repository based on the provided Google ID.
     *
     * @param string $googleId The Google ID of the user.
     * @return User The user entity.
     * @throws UserNotFoundException When the user with the given Google ID is not found.
     */
    public function getByGoogleId(string $googleId): User;

    /**
     * Finds a user entity from the repository based on the provided Google ID.
     *
     * @param string $googleId The Google ID of the user.
     * @return User|null The user entity if found, or null if the user with the given Google ID is not found.
     */
    public function findByGoogleId(string $googleId): ?User;

    /**
     * Creates a new user entity with the given information.
     *
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string|null $password The password of the user (nullable for external logins).
     * @param string $role The new role of the user.
     * @param array $data Additional data for user creation.
     * @return User The newly created user entity.
     */
    public function createUser(string $name, string $email, #[\SensitiveParameter] ?string $password, string $role, array $data = []): User;

    /**
     * Updates an existing user entity with the given information.
     *
     * @param User $user The user entity to update.
     * @param string $name The new name of the user.
     * @param string|null $password The new password of the user (nullable for no password change).
     * @param string $role The new role of the user.
     * @param array $data Additional data for user update.
     */
    public function updateUser(User $user, string $name, #[\SensitiveParameter] ?string $password, string $role, array $data = []): void;

    /**
     * Saves the changes made to a user entity in the repository.
     *
     * @param User $user The user entity to be saved.
     */
    public function save(User $user): void;
}