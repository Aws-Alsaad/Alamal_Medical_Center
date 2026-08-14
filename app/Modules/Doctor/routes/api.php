<?php

use App\Modules\Doctor\Authentication\Http\Controllers\ChangePasswordController;
use App\Modules\Doctor\Authentication\Http\Controllers\LoginController;
use App\Modules\Doctor\Authentication\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:doctor'])->group(function (): void {
    Route::post('auth/logout', [LogoutController::class, 'logout']);
    Route::patch('auth/password', [ChangePasswordController::class, 'changePassword']);
});
