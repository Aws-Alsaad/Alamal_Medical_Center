<?php

namespace App\Modules\SuperAdministrator\SecretaryAccounts\Services;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UpdateSecretaryService
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

    public function updateSecretary(User $actor, User $secretary, array $attributes, ?string $ipAddress): User {
        if ($secretary->role !== UserRole::Secretary) {
            throw (new ModelNotFoundException)->setModel(User::class, [$secretary->id]);
        }

        return DB::transaction(function () use ($actor, $secretary, $attributes, $ipAddress): User {
            $updatedSecretary = $this->userRepository->update($secretary, $attributes);

            $this->auditLogRepository->create([
                'actor_user_id' => $actor->id,
                'action' => 'secretary_account.updated',
                'subject_type' => User::class,
                'subject_id' => $secretary->id,
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return $updatedSecretary;
        });
    }
}
