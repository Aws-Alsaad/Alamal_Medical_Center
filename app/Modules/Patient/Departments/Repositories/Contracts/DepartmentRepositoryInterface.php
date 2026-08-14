<?php

namespace App\Modules\Patient\Departments\Repositories\Contracts;

use App\Models\Department;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Department;
}
