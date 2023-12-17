<?php

namespace App\Domain\User;

interface UserManager
{
    public function getById(string $id): User;

    public function findById(string $id): ?User;

    public function getByEmail(string $email): User;
    public function findByEmail(string $email): ?User;

    public function getByGoogleId(string $googleId): User;
    public function findByGoogleId(string $googleId): ?User;

    public function createUser(string $name, string $email, #[\SensitiveParameter] ?string $password, array $data = []): User;
    public function updateUser(User $user, string $name, #[\SensitiveParameter] ?string $password, string $role,  array $data = []): void;
    public function save(User $user): void;
}