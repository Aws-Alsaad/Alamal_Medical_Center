<?php

namespace App\Modules\Patient\MedicalServices\Services;

use App\Models\MedicalService;
use App\Modules\Patient\MedicalServices\Repositories\Contracts\MedicalServiceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowMedicalServiceService
{
    private MedicalServiceRepositoryInterface $medicalServiceRepository;

    public function __construct(MedicalServiceRepositoryInterface $medicalServiceRepository) {
        $this->medicalServiceRepository = $medicalServiceRepository;
    }

    public function getMedicalService(int $medicalServiceId): MedicalService {
        $medicalService = $this->medicalServiceRepository->findById($medicalServiceId);

        if (! $medicalService) {
            throw (new ModelNotFoundException)->setModel(MedicalService::class, [$medicalServiceId]);
        }

        return $medicalService;
    }
}
