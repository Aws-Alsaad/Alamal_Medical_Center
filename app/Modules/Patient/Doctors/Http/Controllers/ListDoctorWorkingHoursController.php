<?php

namespace App\Modules\Patient\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Doctors\Http\Resources\DoctorWorkingHourResource;
use App\Modules\Patient\Doctors\Services\ListDoctorWorkingHoursService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListDoctorWorkingHoursController extends Controller
{
    private ListDoctorWorkingHoursService $listDoctorWorkingHoursService;

    public function __construct(ListDoctorWorkingHoursService $listDoctorWorkingHoursService) {
        $this->listDoctorWorkingHoursService = $listDoctorWorkingHoursService;
    }

    public function getDoctorWorkingHours(Request $request, int $doctor): JsonResponse {
        $workingHours = $this->listDoctorWorkingHoursService->getDoctorWorkingHours($doctor);
        $data = DoctorWorkingHourResource::collection($workingHours)->resolve($request);

        return ApiResponse::success(
            data: $data,
            message: 'Doctor working hours retrieved successfully.',
        );
    }
}
