<?php

namespace App\Modules\Patient\Doctors\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface DoctorRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?User;

    public function getWorkingHours(User $doctor): Collection;
}
