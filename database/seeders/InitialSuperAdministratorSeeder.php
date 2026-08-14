<?php

namespace Database\Seeders;

use App\Models\User;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use LogicException;

class InitialSuperAdministratorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void {
        $name = config('initial_super_administrator.name');
        $email = config('initial_super_administrator.email');
        $password = config('initial_super_administrator.password');

        if (! is_string($name) || trim($name) === '') {
            throw new LogicException('SUPER_ADMIN_NAME must be configured before seeding.');
        }

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new LogicException('SUPER_ADMIN_EMAIL must contain a valid email address before seeding.');
        }

        if (! is_string($password) || $password === '') {
            throw new LogicException('SUPER_ADMIN_PASSWORD must be configured before seeding.');
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => UserRole::SuperAdministrator,
        ]);
    }
}
