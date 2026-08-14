<?php

namespace App\Modules\Patient\MedicalServices\Services;

use App\Modules\Patient\MedicalServices\Repositories\Contracts\MedicalServiceRepositoryInterface;
use Illuminate\Support\Collection;

class ListMedicalServicesService
{
    private MedicalServiceRepositoryInterface $medicalServiceRepository;

    public function __construct(MedicalServiceRepositoryInterface $medicalServiceRepository) {
        $this->medicalServiceRepository = $medicalServiceRepository;
    }

    public function getMedicalServices(): Collection {
        return $this->medicalServiceRepository->getAll();
    }
}
