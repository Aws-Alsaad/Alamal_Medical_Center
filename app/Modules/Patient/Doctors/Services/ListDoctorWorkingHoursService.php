<?php

namespace App\Modules\Patient\Doctors\Services;

use App\Models\User;
use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ListDoctorWorkingHoursService
{
    private DoctorRepositoryInterface $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository) {
        $this->doctorRepository = $doctorRepository;
    }

    public function getDoctorWorkingHours(int $doctorId): Collection {
        $doctor = $this->doctorRepository->findById($doctorId);

        if (! $doctor) {
            throw (new ModelNotFoundException)->setModel(User::class, [$doctorId]);
        }

        return $this->doctorRepository->getWorkingHours($doctor);
    }
}
