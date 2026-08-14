<?php

namespace App\Modules\Patient\Doctors\Services;

use App\Models\User;
use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowDoctorService
{
    private DoctorRepositoryInterface $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository) {
        $this->doctorRepository = $doctorRepository;
    }

    public function getDoctor(int $doctorId): User {
        $doctor = $this->doctorRepository->findById($doctorId);

        if (! $doctor) {
            throw (new ModelNotFoundException)->setModel(User::class, [$doctorId]);
        }

        return $doctor;
    }
}
