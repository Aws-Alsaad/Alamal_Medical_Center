<?php

namespace Tests\Feature\Shared;

use App\Models\Department;
use App\Models\DoctorWorkingHour;
use App\Models\MedicalService;
use App\Models\User;
use App\Shared\Identity\Enums\UserRole;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DevelopmentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DevelopmentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_the_deterministic_development_fixture(): void {
        $this->seed(DevelopmentSeeder::class);

        foreach ([
            'patient@example.test' => ['Development Patient', UserRole::Patient],
            'doctor@example.test' => ['Development Doctor', UserRole::Doctor],
            'secretary@example.test' => ['Development Secretary', UserRole::Secretary],
            'superadmin@example.test' => ['Development Super Administrator', UserRole::SuperAdministrator],
        ] as $email => [$name, $role]) {
            $user = User::where('email', $email)->sole();

            $this->assertSame($name, $user->name);
            $this->assertSame($role, $user->role);
            $this->assertTrue(Hash::check('Password123!', $user->password));
            $this->assertNotSame('Password123!', $user->password);
        }

        foreach ([
            'Development General Medicine',
            'Development Dentistry',
            'Development Pediatrics',
        ] as $departmentName) {
            $this->assertDatabaseHas('departments', ['name' => $departmentName]);
        }

        foreach ([
            'Development Consultation' => '50.00',
            'Development Dental Examination' => '75.00',
            'Development Pediatric Consultation' => '60.00',
        ] as $serviceName => $cost) {
            $this->assertDatabaseHas('medical_services', [
                'name' => $serviceName,
                'cost' => $cost,
            ]);
        }

        $doctor = User::where('email', 'doctor@example.test')->sole();
        $workingHours = $doctor->workingHours()
            ->orderBy('day_of_week')
            ->get(['day_of_week', 'start_time', 'end_time']);

        $this->assertSame([
            ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
            ['day_of_week' => 3, 'start_time' => '14:00:00', 'end_time' => '18:00:00'],
            ['day_of_week' => 5, 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
        ], $workingHours->toArray());
    }

    public function test_it_is_idempotent_and_preserves_unrelated_records(): void {
        $unrelatedPatient = User::factory()->patient()->create(['email' => 'unrelated-patient@example.test']);
        $unrelatedDoctor = User::factory()->doctor()->create(['email' => 'unrelated-doctor@example.test']);
        $unrelatedDepartment = Department::factory()->create(['name' => 'Unrelated Department']);
        $unrelatedService = MedicalService::factory()->create(['name' => 'Unrelated Service']);
        $unrelatedWorkingHour = DoctorWorkingHour::factory()->create([
            'doctor_user_id' => $unrelatedDoctor->id,
        ]);

        $this->seed(DevelopmentSeeder::class);
        $this->seed(DevelopmentSeeder::class);

        $this->assertDatabaseCount('users', 6);
        $this->assertDatabaseCount('departments', 4);
        $this->assertDatabaseCount('medical_services', 4);
        $this->assertDatabaseCount('doctor_working_hours', 4);

        $this->assertDatabaseHas('users', ['id' => $unrelatedPatient->id]);
        $this->assertDatabaseHas('users', ['id' => $unrelatedDoctor->id]);
        $this->assertDatabaseHas('departments', ['id' => $unrelatedDepartment->id]);
        $this->assertDatabaseHas('medical_services', ['id' => $unrelatedService->id]);
        $this->assertDatabaseHas('doctor_working_hours', ['id' => $unrelatedWorkingHour->id]);

        foreach ([
            'patient@example.test',
            'doctor@example.test',
            'secretary@example.test',
            'superadmin@example.test',
        ] as $email) {
            $this->assertSame(1, User::where('email', $email)->count());
        }
    }

    public function test_database_seeder_keeps_initial_administrator_provisioning_separate(): void {
        config()->set('initial_super_administrator', [
            'name' => 'Configured Initial Administrator',
            'email' => 'configured-initial-administrator@example.test',
            'password' => 'configured-initial-password',
        ]);

        $this->seed(DatabaseSeeder::class);

        $administrator = User::where('email', 'configured-initial-administrator@example.test')->sole();

        $this->assertSame(UserRole::SuperAdministrator, $administrator->role);
        $this->assertTrue(Hash::check('configured-initial-password', $administrator->password));
        $this->assertDatabaseMissing('users', ['email' => 'patient@example.test']);
        $this->assertDatabaseCount('departments', 0);
        $this->assertDatabaseCount('medical_services', 0);
        $this->assertDatabaseCount('doctor_working_hours', 0);
    }
}
