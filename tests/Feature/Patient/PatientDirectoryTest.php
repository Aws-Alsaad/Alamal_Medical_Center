<?php

namespace Tests\Feature\Patient;

use App\Models\Department;
use App\Models\DoctorWorkingHour;
use App\Models\MedicalService;
use App\Models\User;
use App\Modules\Patient\Departments\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Modules\Patient\Departments\Repositories\Eloquent\EloquentDepartmentRepository;
use App\Modules\Patient\Doctors\Repositories\Contracts\DoctorRepositoryInterface;
use App\Modules\Patient\Doctors\Repositories\Eloquent\EloquentDoctorRepository;
use App\Modules\Patient\MedicalServices\Repositories\Contracts\MedicalServiceRepositoryInterface;
use App\Modules\Patient\MedicalServices\Repositories\Eloquent\EloquentMedicalServiceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PatientDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_lists_all_departments_with_the_approved_response_contract(): void {
        $patient = User::factory()->patient()->create();
        Department::factory()->count(17)->create();

        $response = $this->withToken($this->tokenFor($patient))
            ->getJson('/api/patient/departments')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('status_code', 200)
            ->assertJsonPath('message', 'Departments retrieved successfully.')
            ->assertJsonCount(17, 'data')
            ->assertJsonMissingPath('meta');

        $this->assertSame(['id', 'name'], array_keys($response->json('data.0')));
    }

    public function test_patient_views_a_department_and_missing_department_is_standardized(): void {
        $patient = User::factory()->patient()->create();
        $department = Department::factory()->create(['name' => 'Cardiology']);
        $token = $this->tokenFor($patient);

        $this->withToken($token)
            ->getJson("/api/patient/departments/{$department->id}")
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Department retrieved successfully.',
                'data' => ['id' => $department->id, 'name' => 'Cardiology'],
            ]);

        $this->withToken($token)
            ->getJson('/api/patient/departments/999999')
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    public function test_patient_lists_and_views_medical_services_with_decimal_costs(): void {
        $patient = User::factory()->patient()->create();
        $service = MedicalService::factory()->create([
            'name' => 'Consultation',
            'cost' => '125.50',
        ]);
        MedicalService::factory()->count(2)->create();
        $token = $this->tokenFor($patient);

        $list = $this->withToken($token)
            ->getJson('/api/patient/medical-services')
            ->assertOk()
            ->assertJsonPath('data.0.cost', '125.50')
            ->assertJsonCount(3, 'data')
            ->assertJsonMissingPath('meta');

        $this->assertSame(['id', 'name', 'cost'], array_keys($list->json('data.0')));

        $this->withToken($token)
            ->getJson("/api/patient/medical-services/{$service->id}")
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Medical service retrieved successfully.',
                'data' => [
                    'id' => $service->id,
                    'name' => 'Consultation',
                    'cost' => '125.50',
                ],
            ]);
    }

    public function test_missing_medical_service_returns_not_found(): void {
        $patient = User::factory()->patient()->create();
        $token = $this->tokenFor($patient);

        $this->withToken($token)
            ->getJson('/api/patient/medical-services/999999')
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    public function test_patient_lists_only_doctor_role_users_without_sensitive_fields(): void {
        $patient = User::factory()->patient()->create();
        $doctorOne = User::factory()->doctor()->create(['name' => 'Doctor One']);
        $doctorTwo = User::factory()->doctor()->create(['name' => 'Doctor Two']);
        User::factory()->secretary()->create(['name' => 'Not A Doctor']);

        $response = $this->withToken($this->tokenFor($patient))
            ->getJson('/api/patient/doctors')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.id', $doctorOne->id)
            ->assertJsonPath('data.1.id', $doctorTwo->id)
            ->assertJsonMissingPath('data.0.email')
            ->assertJsonMissingPath('data.0.password')
            ->assertJsonMissingPath('data.0.role')
            ->assertJsonMissingPath('meta');

        $this->assertSame(['id', 'name'], array_keys($response->json('data.0')));
    }

    public function test_patient_views_only_a_doctor_role_user_with_public_fields(): void {
        $patient = User::factory()->patient()->create();
        $doctor = User::factory()->doctor()->create([
            'name' => 'Public Doctor',
            'email' => 'private-doctor@example.com',
        ]);
        $nonDoctor = User::factory()->secretary()->create();
        $token = $this->tokenFor($patient);

        $this->withToken($token)
            ->getJson("/api/patient/doctors/{$doctor->id}")
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Doctor retrieved successfully.',
                'data' => ['id' => $doctor->id, 'name' => 'Public Doctor'],
            ]);

        $this->withToken($token)
            ->getJson("/api/patient/doctors/{$nonDoctor->id}")
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');

        $this->withToken($token)
            ->getJson('/api/patient/doctors/999999')
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    public function test_patient_views_only_the_requested_doctors_recurring_working_hours(): void {
        $patient = User::factory()->patient()->create();
        $doctor = User::factory()->doctor()->create();
        $otherDoctor = User::factory()->doctor()->create();
        DoctorWorkingHour::factory()->create([
            'doctor_user_id' => $doctor->id,
            'day_of_week' => 3,
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
        ]);
        DoctorWorkingHour::factory()->create([
            'doctor_user_id' => $doctor->id,
            'day_of_week' => 1,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);
        DoctorWorkingHour::factory()->create([
            'doctor_user_id' => $otherDoctor->id,
            'day_of_week' => 2,
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
        ]);

        $this->withToken($this->tokenFor($patient))
            ->getJson("/api/patient/doctors/{$doctor->id}/working-hours")
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Doctor working hours retrieved successfully.',
                'data' => [
                    ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                    ['day_of_week' => 3, 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                ],
            ]);
    }

    public function test_working_hours_reject_non_doctor_and_missing_targets(): void {
        $patient = User::factory()->patient()->create();
        $secretary = User::factory()->secretary()->create();
        $token = $this->tokenFor($patient);

        $this->withToken($token)
            ->getJson("/api/patient/doctors/{$secretary->id}/working-hours")
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');

        $this->withToken($token)
            ->getJson('/api/patient/doctors/999999/working-hours')
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    #[DataProvider('directoryEndpointProvider')]
    public function test_every_directory_endpoint_requires_authentication(string $endpoint): void {
        $this->getJson($endpoint)
            ->assertUnauthorized()
            ->assertJsonPath('error_code', 'UNAUTHENTICATED');
    }

    #[DataProvider('nonPatientRoleProvider')]
    public function test_non_patient_roles_cannot_access_the_directory(string $factoryState): void {
        $user = User::factory()->{$factoryState}()->create();

        $this->withToken($this->tokenFor($user))
            ->getJson('/api/patient/doctors')
            ->assertForbidden()
            ->assertJsonPath('error_code', 'FORBIDDEN');
    }

    public function test_directory_repository_contracts_resolve_to_eloquent_implementations(): void {
        $this->assertInstanceOf(
            EloquentDepartmentRepository::class,
            $this->app->make(DepartmentRepositoryInterface::class),
        );
        $this->assertInstanceOf(
            EloquentMedicalServiceRepository::class,
            $this->app->make(MedicalServiceRepositoryInterface::class),
        );
        $this->assertInstanceOf(
            EloquentDoctorRepository::class,
            $this->app->make(DoctorRepositoryInterface::class),
        );
    }

    public static function directoryEndpointProvider(): array {
        return [
            'department list' => ['/api/patient/departments'],
            'department show' => ['/api/patient/departments/1'],
            'medical service list' => ['/api/patient/medical-services'],
            'medical service show' => ['/api/patient/medical-services/1'],
            'doctor list' => ['/api/patient/doctors'],
            'doctor show' => ['/api/patient/doctors/1'],
            'working hours' => ['/api/patient/doctors/1/working-hours'],
        ];
    }

    public static function nonPatientRoleProvider(): array {
        return [
            'doctor' => ['doctor'],
            'secretary' => ['secretary'],
            'super administrator' => ['superAdministrator'],
        ];
    }

    private function tokenFor(User $user): string {
        return $user->createToken('patient-directory-test')->plainTextToken;
    }
}
