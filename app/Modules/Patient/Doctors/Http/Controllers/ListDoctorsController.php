<?php

namespace App\Modules\Patient\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Doctors\Http\Resources\DoctorResource;
use App\Modules\Patient\Doctors\Services\ListDoctorsService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListDoctorsController extends Controller
{
    private ListDoctorsService $listDoctorsService;

    public function __construct(ListDoctorsService $listDoctorsService) {
        $this->listDoctorsService = $listDoctorsService;
    }

    public function getDoctors(Request $request): JsonResponse {
        $doctors = $this->listDoctorsService->getDoctors();
        $data = DoctorResource::collection($doctors)->resolve($request);

        return ApiResponse::success($data, 'Doctors retrieved successfully.');
    }
}
