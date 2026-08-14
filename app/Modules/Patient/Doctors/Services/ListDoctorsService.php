<?php

namespace App\Modules\Patient\Doctors\Services;

use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Support\Collection;

class ListDoctorsService
{
    private DoctorRepositoryInterface $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository) {
        $this->doctorRepository = $doctorRepository;
    }

    public function getDoctors(): Collection {
        return $this->doctorRepository->getAll();
    }
}
