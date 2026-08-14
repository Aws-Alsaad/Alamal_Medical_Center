<?php

namespace App\Shared\Identity\Services;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LogoutService
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

    public function logout(User $user, ?string $ipAddress): void {
        DB::transaction(function () use ($user, $ipAddress): void {
            $this->userRepository->revokeCurrentAccessToken($user);

            $this->auditLogRepository->create([
                'actor_user_id' => $user->id,
                'action' => 'authentication.logout',
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);
        });
    }
}
