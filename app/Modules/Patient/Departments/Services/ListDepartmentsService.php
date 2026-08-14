<?php

namespace App\Modules\Patient\Departments\Services;

use App\Modules\Patient\Departments\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class ListDepartmentsService
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartments(): Collection {
        return $this->departmentRepository->getAll();
    }
}
