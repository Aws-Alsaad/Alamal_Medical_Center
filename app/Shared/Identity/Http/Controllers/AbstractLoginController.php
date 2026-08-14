<?php

namespace App\Shared\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Http\Requests\LoginRequest;
use App\Shared\Identity\Http\Resources\AuthenticatedSessionResource;
use App\Shared\Identity\Services\LoginService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class AbstractLoginController extends Controller
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService) {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request): JsonResponse {
        $session = $this->loginService->login(
            email: $request->validated('email'),
            password: $request->validated('password'),
            expectedRole: $this->expectedRole(),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: (new AuthenticatedSessionResource($session))->resolve($request),
            message: 'Authenticated successfully.',
        );
    }

    abstract protected function expectedRole(): UserRole;
}
