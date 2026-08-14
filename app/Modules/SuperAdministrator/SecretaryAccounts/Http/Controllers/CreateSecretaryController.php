<?php

namespace App\Modules\SuperAdministrator\SecretaryAccounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Requests\CreateSecretaryRequest;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Resources\SecretaryAccountResource;
use App\Modules\SuperAdministrator\SecretaryAccounts\Services\CreateSecretaryService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class CreateSecretaryController extends Controller
{
    private CreateSecretaryService $createSecretaryService;

    public function __construct(CreateSecretaryService $createSecretaryService) {
        $this->createSecretaryService = $createSecretaryService;
    }

    public function createSecretary(CreateSecretaryRequest $request): JsonResponse {
        $secretary = $this->createSecretaryService->createSecretary(
            actor: $request->user(),
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: (new SecretaryAccountResource($secretary))->resolve($request),
            message: 'Secretary account created successfully.',
            status: 201,
        );
    }
}
