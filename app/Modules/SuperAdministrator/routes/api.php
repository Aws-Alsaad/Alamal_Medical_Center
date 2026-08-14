<?php

use App\Modules\SuperAdministrator\Authentication\Http\Controllers\ChangePasswordController;
use App\Modules\SuperAdministrator\Authentication\Http\Controllers\LoginController;
use App\Modules\SuperAdministrator\Authentication\Http\Controllers\LogoutController;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Controllers\CreateDoctorController;
use App\Modules\SuperAdministrator\DoctorAccounts\Http\Controllers\UpdateDoctorController;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Controllers\CreateSecretaryController;
use App\Modules\SuperAdministrator\SecretaryAccounts\Http\Controllers\UpdateSecretaryController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:super_administrator'])->group(function (): void {
    Route::post('auth/logout', [LogoutController::class, 'logout']);
    Route::patch('auth/password', [ChangePasswordController::class, 'changePassword']);
    Route::post('doctors', [CreateDoctorController::class, 'createDoctor']);
    Route::patch('doctors/{doctor}', [UpdateDoctorController::class, 'updateDoctor']);
    Route::post('secretaries', [CreateSecretaryController::class, 'createSecretary']);
    Route::patch('secretaries/{secretary}', [UpdateSecretaryController::class, 'updateSecretary']);
});
