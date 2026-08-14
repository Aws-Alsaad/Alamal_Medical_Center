<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleRouteServiceProvider extends ServiceProvider
{
    public const ROLE_ROUTES = [
        'api/patient' => 'app/Modules/Patient/routes/api.php',
        'api/doctor' => 'app/Modules/Doctor/routes/api.php',
        'api/secretary' => 'app/Modules/Secretary/routes/api.php',
        'api/super-administrator' => 'app/Modules/SuperAdministrator/routes/api.php',
    ];

    public function boot(): void {
        foreach (self::ROLE_ROUTES as $prefix => $routeFile) {
            Route::middleware('api')
                ->prefix($prefix)
                ->group(base_path($routeFile));
        }
    }
}
