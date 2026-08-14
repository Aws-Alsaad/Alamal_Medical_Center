<?php

namespace App\Shared\Identity\Services;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChangePasswordService
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

    public function changePassword(User $user, string $password, ?string $ipAddress): User {
        return DB::transaction(function () use ($user, $password, $ipAddress): User {
            $updatedUser = $this->userRepository->update($user, ['password' => $password]);

            $this->auditLogRepository->create([
                'actor_user_id' => $user->id,
                'action' => 'authentication.password_changed',
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return $updatedUser;
        });
    }
}
