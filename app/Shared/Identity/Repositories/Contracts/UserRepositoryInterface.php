<?php

namespace App\Shared\Identity\Repositories\Contracts;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): User;

    public function createAccessToken(User $user, string $name): NewAccessToken;

    public function revokeCurrentAccessToken(User $user): void;
}
