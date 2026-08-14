<?php

use App\Providers\AppServiceProvider;
use App\Providers\ModuleRouteServiceProvider;
use App\Providers\RepositoryServiceProvider;

return [
    AppServiceProvider::class,
    ModuleRouteServiceProvider::class,
    RepositoryServiceProvider::class,
];
