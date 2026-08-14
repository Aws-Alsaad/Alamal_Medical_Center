<?php

namespace App\Modules\SuperAdministrator\SecretaryAccounts\Services;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateSecretaryService
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

    public function createSecretary(
        User $actor,
        string $name,
        string $email,
        string $password,
        ?string $ipAddress,
    ): User {
        return DB::transaction(function () use ($actor, $name, $email, $password, $ipAddress): User {
            $secretary = $this->userRepository->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => UserRole::Secretary,
            ]);

            $this->auditLogRepository->create([
                'actor_user_id' => $actor->id,
                'action' => 'secretary_account.created',
                'subject_type' => User::class,
                'subject_id' => $secretary->id,
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return $secretary;
        });
    }
}
