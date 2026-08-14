<?php

namespace App\Modules\Patient\Departments\Services;

use App\Models\Department;
use App\Modules\Patient\Departments\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowDepartmentService
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartment(int $departmentId): Department {
        $department = $this->departmentRepository->findById($departmentId);

        if (! $department) {
            throw (new ModelNotFoundException)->setModel(Department::class, [$departmentId]);
        }

        return $department;
    }
}
