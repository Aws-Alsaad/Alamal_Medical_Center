<?php

namespace App\Modules\Patient\Doctors\Repositories\Eloquent;

use App\Models\User;
use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Support\Collection;

class EloquentDoctorRepository implements DoctorRepositoryInterface
{
    public function getAll(): Collection {
        return User::where('role', UserRole::Doctor->value)
            ->orderBy('id')
            ->get();
    }

    public function findById(int $id): ?User {
        return User::where('role', UserRole::Doctor->value)
            ->find($id);
    }

    public function getWorkingHours(User $doctor): Collection {
        return $doctor->workingHours()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->orderBy('id')
            ->get();
    }
}
