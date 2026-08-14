<?php

namespace App\Shared\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Identity\Services\LogoutService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractLogoutController extends Controller
{
    private LogoutService $logoutService;

    public function __construct(LogoutService $logoutService) {
        $this->logoutService = $logoutService;
    }

    public function logout(Request $request): JsonResponse {
        $this->logoutService->logout($request->user(), $request->ip());

        return ApiResponse::success(
            data: null,
            message: 'Logged out successfully.',
        );
    }
}
