<?php

namespace App\Modules\SuperAdministrator\DoctorAccounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Requests\CreateDoctorRequest;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Resources\DoctorAccountResource;
use App\Modules\SuperAdministrator\DoctorAccounts\Services\CreateDoctorService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class CreateDoctorController extends Controller
{
    private CreateDoctorService $createDoctorService;

    public function __construct(CreateDoctorService $createDoctorService) {
        $this->createDoctorService = $createDoctorService;
    }

    public function createDoctor(CreateDoctorRequest $request): JsonResponse {
        $doctor = $this->createDoctorService->createDoctor(
            actor: $request->user(),
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: (new DoctorAccountResource($doctor))->resolve($request),
            message: 'Doctor account created successfully.',
            status: 201,
        );
    }
}
