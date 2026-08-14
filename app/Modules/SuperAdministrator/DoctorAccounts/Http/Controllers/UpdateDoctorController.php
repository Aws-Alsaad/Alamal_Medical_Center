<?php

namespace App\Modules\SuperAdministrator\DoctorAccounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Requests\UpdateDoctorRequest;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Resources\DoctorAccountResource;
use App\Modules\SuperAdministrator\DoctorAccounts\Services\UpdateDoctorService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class UpdateDoctorController extends Controller
{
    private UpdateDoctorService $updateDoctorService;

    public function __construct(UpdateDoctorService $updateDoctorService) {
        $this->updateDoctorService = $updateDoctorService;
    }

    public function updateDoctor(UpdateDoctorRequest $request, User $doctor): JsonResponse {
        $doctor = $this->updateDoctorService->updateDoctor(
            actor: $request->user(),
            doctor: $doctor,
            attributes: $request->safe()->only(['name', 'email']),
            ipAddress: $request->ip(),
        );

        return ApiResponse::success(
            data: (new DoctorAccountResource($doctor))->resolve($request),
            message: 'Doctor account updated successfully.',
        );
    }
}
