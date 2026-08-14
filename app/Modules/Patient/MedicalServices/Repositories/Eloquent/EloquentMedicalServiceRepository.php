<?php

namespace App\Modules\Patient\MedicalServices\Repositories\Eloquent;

use App\Models\MedicalService;
use App\Modules\Patient\MedicalServices\Repositories\Contracts\MedicalServiceRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentMedicalServiceRepository implements MedicalServiceRepositoryInterface
{
    public function getAll(): Collection {
        return MedicalService::all();
    }

    public function findById(int $id): ?MedicalService {
        return MedicalService::find($id);
    }
}
