<?php

namespace App\Modules\Patient\Departments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Departments\Http\Resources\DepartmentResource;
use App\Modules\Patient\Departments\Services\ListDepartmentsService;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListDepartmentsController extends Controller
{
    private ListDepartmentsService $listDepartmentsService;

    public function __construct(ListDepartmentsService $listDepartmentsService) {
        $this->listDepartmentsService = $listDepartmentsService;
    }

    public function getDepartments(Request $request): JsonResponse {
        $departments = $this->listDepartmentsService->getDepartments();
        $data = DepartmentResource::collection($departments)->resolve($request);

        return ApiResponse::success($data, 'Departments retrieved successfully.');
    }
}
