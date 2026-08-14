<?php

namespace Tests\Feature;

use App\Providers\ModuleRouteServiceProvider;
use App\Shared\Support\Http\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Tests\TestCase;

class ApplicationFoundationTest extends TestCase
{
    public function test_the_laravel_application_boots_successfully(): void {
        $this->assertTrue($this->app->bound(Kernel::class));
        $this->assertSame('testing', $this->app->environment());
    }

    public function test_the_module_route_service_provider_is_registered(): void {
        $provider = $this->app->getProvider(ModuleRouteServiceProvider::class);

        $this->assertInstanceOf(ModuleRouteServiceProvider::class, $provider);
    }

    public function test_the_four_approved_role_route_files_exist_and_are_loadable(): void {
        $this->assertSame([
            'api/patient' => 'app/Modules/Patient/routes/api.php',
            'api/doctor' => 'app/Modules/Doctor/routes/api.php',
            'api/secretary' => 'app/Modules/Secretary/routes/api.php',
            'api/super-administrator' => 'app/Modules/SuperAdministrator/routes/api.php',
        ], ModuleRouteServiceProvider::ROLE_ROUTES);

        foreach (ModuleRouteServiceProvider::ROLE_ROUTES as $routeFile) {
            $absolutePath = base_path($routeFile);

            $this->assertFileExists($absolutePath);
            $this->assertFileIsReadable($absolutePath);
        }
    }

    public function test_no_versioned_or_undocumented_api_routes_are_registered(): void {
        $apiRoutes = collect(Route::getRoutes()->getRoutes())
            ->map(static fn ($route): string => $route->uri())
            ->filter(static fn (string $uri): bool => str_starts_with($uri, 'api/'))
            ->values();

        $this->assertFalse(
            $apiRoutes->contains(static fn (string $uri): bool => str_starts_with($uri, 'api/v1')),
        );
        $this->assertSame([
            'api/patient/auth/login',
            'api/patient/auth/logout',
            'api/patient/auth/password',
            'api/patient/departments',
            'api/patient/departments/{department}',
            'api/patient/medical-services',
            'api/patient/medical-services/{medical_service}',
            'api/patient/doctors',
            'api/patient/doctors/{doctor}',
            'api/patient/doctors/{doctor}/working-hours',
            'api/doctor/auth/login',
            'api/doctor/auth/logout',
            'api/doctor/auth/password',
            'api/secretary/auth/login',
            'api/secretary/auth/logout',
            'api/secretary/auth/password',
            'api/super-administrator/auth/login',
            'api/super-administrator/auth/logout',
            'api/super-administrator/auth/password',
            'api/super-administrator/doctors',
            'api/super-administrator/doctors/{doctor}',
            'api/super-administrator/secretaries',
            'api/super-administrator/secretaries/{secretary}',
        ], $apiRoutes->all());
    }

    public function test_api_routes_use_explicit_controller_action_methods(): void {
        $routeActions = collect(Route::getRoutes()->getRoutes())
            ->filter(static fn ($route): bool => str_starts_with($route->uri(), 'api/'))
            ->mapWithKeys(static fn ($route): array => [$route->uri() => $route->getActionMethod()])
            ->all();

        $this->assertSame([
            'api/patient/auth/login' => 'login',
            'api/patient/auth/logout' => 'logout',
            'api/patient/auth/password' => 'changePassword',
            'api/patient/departments' => 'getDepartments',
            'api/patient/departments/{department}' => 'getDepartment',
            'api/patient/medical-services' => 'getMedicalServices',
            'api/patient/medical-services/{medical_service}' => 'getMedicalService',
            'api/patient/doctors' => 'getDoctors',
            'api/patient/doctors/{doctor}' => 'getDoctor',
            'api/patient/doctors/{doctor}/working-hours' => 'getDoctorWorkingHours',
            'api/doctor/auth/login' => 'login',
            'api/doctor/auth/logout' => 'logout',
            'api/doctor/auth/password' => 'changePassword',
            'api/secretary/auth/login' => 'login',
            'api/secretary/auth/logout' => 'logout',
            'api/secretary/auth/password' => 'changePassword',
            'api/super-administrator/auth/login' => 'login',
            'api/super-administrator/auth/logout' => 'logout',
            'api/super-administrator/auth/password' => 'changePassword',
            'api/super-administrator/doctors' => 'createDoctor',
            'api/super-administrator/doctors/{doctor}' => 'updateDoctor',
            'api/super-administrator/secretaries' => 'createSecretary',
            'api/super-administrator/secretaries/{secretary}' => 'updateSecretary',
        ], $routeActions);
    }

    public function test_sanctum_is_installed_and_its_standard_token_migration_is_present(): void {
        $this->assertTrue(class_exists(Sanctum::class));

        $composer = json_decode((string) file_get_contents(base_path('composer.json')), true);
        $this->assertArrayHasKey('laravel/sanctum', $composer['require']);

        $migrations = glob(database_path('migrations/*_create_personal_access_tokens_table.php'));

        $this->assertIsArray($migrations);
        $this->assertCount(1, $migrations);
        $this->assertStringContainsString(
            "Schema::create('personal_access_tokens'",
            (string) file_get_contents($migrations[0]),
        );
    }

    public function test_unknown_api_routes_return_the_standardized_not_found_response(): void {
        $this->getJson('/api/route-that-does-not-exist')
            ->assertNotFound()
            ->assertExactJson([
                'success' => false,
                'status_code' => 404,
                'message' => 'The requested resource was not found.',
                'error_code' => 'RESOURCE_NOT_FOUND',
            ]);
    }

    public function test_api_validation_failures_return_field_level_errors(): void {
        Route::post('/api/_foundation/validation', function (Request $request): JsonResponse {
            $request->validate([
                'name' => ['required', 'string'],
            ]);

            return ApiResponse::success();
        });

        $this->postJson('/api/_foundation/validation')
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status_code', 422)
            ->assertJsonPath('message', 'The provided data is invalid.')
            ->assertJsonPath('error_code', 'VALIDATION_ERROR')
            ->assertJsonValidationErrors('name');
    }

    public function test_unauthenticated_api_exceptions_use_the_standardized_response(): void {
        Route::get('/api/_foundation/unauthenticated', function (): void {
            throw new AuthenticationException('Sensitive authentication detail.');
        });

        $this->getJson('/api/_foundation/unauthenticated')
            ->assertUnauthorized()
            ->assertExactJson([
                'success' => false,
                'status_code' => 401,
                'message' => 'Authentication is required.',
                'error_code' => 'UNAUTHENTICATED',
            ]);
    }

    public function test_forbidden_api_exceptions_use_the_standardized_response(): void {
        Route::get('/api/_foundation/forbidden', function (): void {
            throw new AuthorizationException('Sensitive authorization detail.');
        });

        $this->getJson('/api/_foundation/forbidden')
            ->assertForbidden()
            ->assertExactJson([
                'success' => false,
                'status_code' => 403,
                'message' => 'You are not authorized to perform this action.',
                'error_code' => 'FORBIDDEN',
            ]);
    }

    public function test_throttled_api_exceptions_use_the_standardized_response(): void {
        Route::get('/api/_foundation/throttled', function (): void {
            throw new TooManyRequestsHttpException(null, 'Sensitive throttle detail.');
        });

        $this->getJson('/api/_foundation/throttled')
            ->assertStatus(429)
            ->assertExactJson([
                'success' => false,
                'status_code' => 429,
                'message' => 'Too many requests. Please try again later.',
                'error_code' => 'TOO_MANY_REQUESTS',
            ]);
    }

    public function test_unexpected_api_exceptions_return_only_safe_generic_details(): void {
        Route::get('/api/_foundation/unexpected', function (): void {
            throw new RuntimeException('Sensitive failure in C:\\private\\application.php.');
        });

        $response = $this->getJson('/api/_foundation/unexpected')
            ->assertInternalServerError()
            ->assertExactJson([
                'success' => false,
                'status_code' => 500,
                'message' => 'An unexpected server error occurred.',
                'error_code' => 'INTERNAL_SERVER_ERROR',
            ]);

        $this->assertStringNotContainsString('RuntimeException', (string) $response->getContent());
        $this->assertStringNotContainsString('C:\\private', (string) $response->getContent());
        $this->assertStringNotContainsString('trace', (string) $response->getContent());
    }
}
