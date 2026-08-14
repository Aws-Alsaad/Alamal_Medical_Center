<?php

namespace App\Modules\SuperAdministrator\SecretaryAccounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Requests\UpdateSecretaryRequest;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Resources\SecretaryAccountResource;
use App\Modules\SuperAdministrator\SecretaryAccounts\Services\UpdateSecretaryService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class UpdateSecretaryController extends Controller
{
    private UpdateSecretaryService $updateSecretaryService;

    public function __construct(UpdateSecretaryService $updateSecretaryService) {
        $this->updateSecretaryService = $updateSecretaryService;
    }

    public function updateSecretary(UpdateSecretaryRequest $request, User $secretary): JsonResponse {
        $secretary = $this->updateSecretaryService->updateSecretary(
            actor: $request->user(),
            secretary: $secretary,
            attributes: $request->safe()->only(['name', 'email']),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: (new SecretaryAccountResource($secretary))->resolve($request),
            message: 'Secretary account updated successfully.',
        );
    }
}
