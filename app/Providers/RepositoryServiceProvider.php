<?php

namespace App\Providers;

use App\Modules\Patient\Departments\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Modules\Patient\Departments\Repositories\Eloquent\EloquentDepartmentRepository;
use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use App\Modules\Patient\Doctors\Repositories\Eloquent\EloquentDoctorRepository;
use App\Modules\Patient\MedicalServices\Repositories\Contracts\MedicalServiceRepositoryInterface;
use App\Modules\Patient\MedicalServices\Repositories\Eloquent\EloquentMedicalServiceRepository;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Audit\Repositories\Eloquent\EloquentAuditLogRepository;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use App\Shared\Identity\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(AuditLogRepositoryInterface::class, EloquentAuditLogRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, EloquentDepartmentRepository::class);
        $this->app->bind(MedicalServiceRepositoryInterface::class, EloquentMedicalServiceRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class, EloquentDoctorRepository::class);
    }
}
