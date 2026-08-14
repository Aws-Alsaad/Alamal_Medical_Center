<?php

namespace App\Modules\Patient\Departments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Departments\Http\Resources\DepartmentResource;
use App\Modules\Patient\Departments\Services\ShowDepartmentService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowDepartmentController extends Controller
{
    private ShowDepartmentService $showDepartmentService;

    public function __construct(ShowDepartmentService $showDepartmentService) {
        $this->showDepartmentService = $showDepartmentService;
    }

    public function getDepartment(Request $request, int $department): JsonResponse {
        $department = $this->showDepartmentService->getDepartment($department);

        return ApiResponse::success(
            data: (new DepartmentResource($department))->resolve($request),
            message: 'Department retrieved successfully.',
        );
    }
}
