<?php

namespace App\Modules\Patient\MedicalServices\Repositories\Contracts;

use App\Models\MedicalService;
use Illuminate\Support\Collection;

interface MedicalServiceRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?MedicalService;
}
