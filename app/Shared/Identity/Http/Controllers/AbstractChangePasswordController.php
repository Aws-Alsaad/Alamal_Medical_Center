<?php

namespace App\Shared\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Identity\Http\Requests\ChangePasswordRequest;
use App\Shared\Identity\Services\ChangePasswordService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class AbstractChangePasswordController extends Controller
{
    private ChangePasswordService $changePasswordService;

    public function __construct(ChangePasswordService $changePasswordService) {
        $this->changePasswordService = $changePasswordService;
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse {
        $this->changePasswordService->changePassword(
            user: $request->user(),
            password: $request->validated('password'),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: null,
            message: 'Password changed successfully.',
        );
    }
}
