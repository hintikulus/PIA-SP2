<?php

namespace App\Domain\User;

interface UserService
{
    public function getById(string $id): User;
    public function findById(string $id): ?User;

    public function getByEmail(string $email): User;
    public function findByEmail(string $email): ?User;

    public function getByGoogleId(string $googleId): User;
    public function findByGoogleId(string $googleId): ?User;
    public function getAll(): array;
    public function getAllDataSource(): mixed;

    public function createUser(string $name, string $email, string $password, array $data = []): User;

    public function updateUser(User $user, string $name, ?string $password, string $role, array $data = []): void;
    public function updateLastLoginDatetime(User $user): void;
}