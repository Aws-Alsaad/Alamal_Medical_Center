<?php

namespace App\Modules\Patient\MedicalServices\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\MedicalServices\Http\Resources\MedicalServiceResource;
use App\Modules\Patient\MedicalServices\Services\ShowMedicalServiceService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowMedicalServiceController extends Controller
{
    private ShowMedicalServiceService $showMedicalServiceService;

    public function __construct(ShowMedicalServiceService $showMedicalServiceService) {
        $this->showMedicalServiceService = $showMedicalServiceService;
    }

    public function getMedicalService(Request $request, int $medical_service): JsonResponse {
        $medicalService = $this->showMedicalServiceService->getMedicalService($medical_service);

        return ApiResponse::success(
            data: (new MedicalServiceResource($medicalService))->resolve($request),
            message: 'Medical service retrieved successfully.',
        );
    }
}
