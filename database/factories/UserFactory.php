<?php

namespace Database\Factories;

use App\Models\User;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    /** @var class-string<User> */
    protected $model = User::class;

    protected static ?string $password;

    /** @return array<string, mixed> */
    public function definition(): array {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Patient,
        ];
    }

    public function patient(): static {
        return $this->state(fn (): array => ['role' => UserRole::Patient]);
    }

    public function doctor(): static {
        return $this->state(fn (): array => ['role' => UserRole::Doctor]);
    }

    public function secretary(): static {
        return $this->state(fn (): array => ['role' => UserRole::Secretary]);
    }

    public function superAdministrator(): static {
        return $this->state(fn (): array => ['role' => UserRole::SuperAdministrator]);
    }
}
