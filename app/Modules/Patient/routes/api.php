<?php

use App\Modules\Patient\Authentication\Http\Controllers\ChangePasswordController;
use App\Modules\Patient\Authentication\Http\Controllers\LoginController;
use App\Modules\Patient\Authentication\Http\Controllers\LogoutController;
use App\Modules\Patient\Departments\Http\Controllers\ListDepartmentsController;
use App\Modules\Patient\Departments\Http\Controllers\ShowDepartmentController;
use App\Modules\Patient\Doctors\Http\Controllers\ListDoctorsController;
use App\Modules\Patient\Doctors\Http\Controllers\ListDoctorWorkingHoursController;
use App\Modules\Patient\Doctors\Http\Controllers\ShowDoctorController;
use App\Modules\Patient\MedicalServices\Http\Controllers\ListMedicalServicesController;
use App\Modules\Patient\MedicalServices\Http\Controllers\ShowMedicalServiceController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:patient'])->group(function (): void {
    Route::post('auth/logout', [LogoutController::class, 'logout']);
    Route::patch('auth/password', [ChangePasswordController::class, 'changePassword']);
    Route::get('departments', [ListDepartmentsController::class, 'getDepartments']);
    Route::get('departments/{department}', [ShowDepartmentController::class, 'getDepartment']);
    Route::get('medical-services', [ListMedicalServicesController::class, 'getMedicalServices']);
    Route::get('medical-services/{medical_service}', [ShowMedicalServiceController::class, 'getMedicalService']);
    Route::get('doctors', [ListDoctorsController::class, 'getDoctors']);
    Route::get('doctors/{doctor}', [ShowDoctorController::class, 'getDoctor']);
    Route::get('doctors/{doctor}/working-hours', [ListDoctorWorkingHoursController::class, 'getDoctorWorkingHours']);
});
