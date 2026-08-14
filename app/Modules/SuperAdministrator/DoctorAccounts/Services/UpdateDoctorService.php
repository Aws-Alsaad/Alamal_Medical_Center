<?php

namespace App\Modules\SuperAdministrator\DoctorAccounts\Services;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UpdateDoctorService
{
    private UserRepositoryInterface $userRepository;

    private AuditLogRepositoryInterface $auditLogRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuditLogRepositoryInterface $auditLogRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->auditLogRepository = $auditLogRepository;
    }

    public function updateDoctor(User $actor, User $doctor, array $attributes, ?string $ipAddress): User {
        if ($doctor->role !== UserRole::Doctor) {
            throw (new ModelNotFoundException)->setModel(User::class, [$doctor->id]);
        }

        return DB::transaction(function () use ($actor, $doctor, $attributes, $ipAddress): User {
            $updatedDoctor = $this->userRepository->update($doctor, $attributes);

            $this->auditLogRepository->create([
                'actor_user_id' => $actor->id,
                'action' => 'doctor_account.updated',
                'subject_type' => User::class,
                'subject_id' => $doctor->id,
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return $updatedDoctor;
        });
    }
}
