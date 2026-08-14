<?php

namespace App\Modules\Patient\MedicalServices\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\MedicalServices\Http\Resources\MedicalServiceResource;
use App\Modules\Patient\MedicalServices\Services\ListMedicalServicesService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListMedicalServicesController extends Controller
{
    private ListMedicalServicesService $listMedicalServicesService;

    public function __construct(ListMedicalServicesService $listMedicalServicesService) {
        $this->listMedicalServicesService = $listMedicalServicesService;
    }

    public function getMedicalServices(Request $request): JsonResponse {
        $medicalServices = $this->listMedicalServicesService->getMedicalServices();
        $data = MedicalServiceResource::collection($medicalServices)->resolve($request);

        return ApiResponse::success($data, 'Medical services retrieved successfully.');
    }
}
