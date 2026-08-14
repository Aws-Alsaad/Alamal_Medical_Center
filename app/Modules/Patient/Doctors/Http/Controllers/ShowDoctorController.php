<?php

namespace App\Modules\Patient\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Doctors\Http\Resources\DoctorResource;
use App\Modules\Patient\Doctors\Services\ShowDoctorService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowDoctorController extends Controller
{
    private ShowDoctorService $showDoctorService;

    public function __construct(ShowDoctorService $showDoctorService) {
        $this->showDoctorService = $showDoctorService;
    }

    public function getDoctor(Request $request, int $doctor): JsonResponse {
        $doctor = $this->showDoctorService->getDoctor($doctor);

        return ApiResponse::success(
            data: (new DoctorResource($doctor))->resolve($request),
            message: 'Doctor retrieved successfully.',
        );
    }
}
