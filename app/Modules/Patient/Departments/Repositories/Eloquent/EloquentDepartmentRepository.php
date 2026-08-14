<?php

namespace App\Modules\Patient\Departments\Repositories\Eloquent;

use App\Models\Department;
use App\Modules\Patient\Departments\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentDepartmentRepository implements DepartmentRepositoryInterface
{
    public function getAll(): Collection {
        return Department::all();
    }

    public function findById(int $id): ?Department {
        return Department::find($id);
    }
}
