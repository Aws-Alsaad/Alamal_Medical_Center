<?php

namespace App\Shared\Identity\Repositories\Eloquent;

use App\Models\User;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User {
        return User::where('email', $email)->first();
    }

    public function create(array $attributes): User {
        return User::create($attributes);
    }

    public function update(User $user, array $attributes): User {
        $user->update($attributes);

        return $user->refresh();
    }

    public function createAccessToken(User $user, string $name): NewAccessToken {
        return $user->createToken($name);
    }

    public function revokeCurrentAccessToken(User $user): void {
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }
}
