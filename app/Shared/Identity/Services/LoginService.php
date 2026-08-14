<?php

namespace App\Shared\Identity\Services;

use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Exceptions\InvalidCredentialsException;
use App\Shared\Identity\Exceptions\RoleMismatchException;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginService
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

    public function login(string $email, string $password, UserRole $expectedRole, ?string $ipAddress): array {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            $this->auditLogRepository->create([
                'actor_user_id' => $user?->id,
                'action' => 'authentication.login',
                'outcome' => 'failure',
                'metadata' => ['reason' => 'invalid_credentials'],
                'ip_address' => $ipAddress,
            ]);

            throw new InvalidCredentialsException;
        }

        if ($user->role !== $expectedRole) {
            $this->auditLogRepository->create([
                'actor_user_id' => $user->id,
                'action' => 'authentication.login',
                'outcome' => 'failure',
                'metadata' => ['reason' => 'role_mismatch'],
                'ip_address' => $ipAddress,
            ]);

            throw new RoleMismatchException;
        }

        return DB::transaction(function () use ($user, $expectedRole, $ipAddress): array {
            $accessToken = $this->userRepository->createAccessToken($user, $expectedRole->value.'-api');

            $this->auditLogRepository->create([
                'actor_user_id' => $user->id,
                'action' => 'authentication.login',
                'outcome' => 'success',
                'ip_address' => $ipAddress,
            ]);

            return [
                'user' => $user,
                'token' => $accessToken->plainTextToken,
            ];
        });
    }
}
