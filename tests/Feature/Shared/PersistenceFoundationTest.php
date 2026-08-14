<?php

namespace Tests\Feature\Shared;

use App\Models\AuditLog;
use App\Models\Department;
use App\Models\DoctorWorkingHour;
use App\Models\MedicalService;
use App\Models\User;
use App\Providers\RepositoryServiceProvider;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Audit\Repositories\Eloquent\EloquentAuditLogRepository;
use App\Shared\Identity\Enums\UserRole;
use App\Shared\Identity\Repositories\Contracts\UserRepositoryInterface;
use App\Shared\Identity\Repositories\Eloquent\EloquentUserRepository;
use Database\Seeders\InitialSuperAdministratorSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
use Tests\TestCase;
use ValueError;

class PersistenceFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_the_approved_application_tables_are_migrated(): void {
        foreach ([
            'users',
            'departments',
            'medical_services',
            'doctor_working_hours',
            'audit_logs',
            'personal_access_tokens',
        ] as $table) {
            $this->assertTrue(Schema::hasTable($table), "Expected [{$table}] to exist.");
        }

        foreach ([
            'password_reset_tokens',
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
        ] as $table) {
            $this->assertFalse(Schema::hasTable($table), "Did not expect [{$table}] to exist.");
        }
    }

    public function test_users_have_exactly_the_approved_columns(): void {
        $columns = Schema::getColumnListing('users');
        sort($columns);

        $expected = ['created_at', 'email', 'id', 'name', 'password', 'role', 'updated_at'];
        sort($expected);

        $this->assertSame($expected, $columns);
    }

    public function test_user_roles_cast_and_unsupported_roles_are_rejected(): void {
        $doctor = User::factory()->doctor()->create();

        $this->assertSame(UserRole::Doctor, $doctor->role);
        $this->assertDatabaseHas('users', [
            'id' => $doctor->id,
            'role' => 'doctor',
        ]);

        $this->expectException(ValueError::class);

        User::factory()->create(['role' => 'unsupported']);
    }

    public function test_user_email_is_unique(): void {
        User::factory()->create(['email' => 'unique@example.test']);

        $this->expectException(QueryException::class);

        User::factory()->create(['email' => 'unique@example.test']);
    }

    public function test_directory_models_persist_the_approved_fields(): void {
        $department = Department::factory()->create(['name' => 'Cardiology']);
        $service = MedicalService::factory()->create([
            'name' => 'Consultation',
            'cost' => '125.50',
        ]);

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'name' => 'Cardiology',
        ]);
        $this->assertDatabaseHas('medical_services', [
            'id' => $service->id,
            'name' => 'Consultation',
            'cost' => 125.50,
        ]);
        $this->assertSame('125.50', $service->cost);
    }

    public function test_negative_medical_service_cost_is_rejected_by_application_and_database(): void {
        try {
            MedicalService::factory()->create(['cost' => -1]);
            $this->fail('Application persistence accepted a negative medical-service cost.');
        }
        catch (InvalidArgumentException) {
            $this->assertDatabaseCount('medical_services', 0);
        }

        $this->expectException(QueryException::class);

        DB::table('medical_services')->insert([
            'name' => 'Invalid service',
            'cost' => -1,
        ]);
    }

    public function test_working_hours_persist_for_doctors_and_expose_confirmed_relationships(): void {
        $doctor = User::factory()->doctor()->create();
        $workingHour = DoctorWorkingHour::factory()->create([
            'doctor_user_id' => $doctor->id,
            'day_of_week' => 1,
            'start_time' => '09:00:00',
            'end_time' => '13:00:00',
        ]);

        $this->assertTrue($workingHour->doctor->is($doctor));
        $this->assertTrue($doctor->workingHours->contains($workingHour));
    }

    public function test_working_hours_require_a_doctor_role_and_valid_values(): void {
        $patient = User::factory()->patient()->create();

        try {
            DoctorWorkingHour::factory()->create(['doctor_user_id' => $patient->id]);
            $this->fail('Application persistence accepted a non-Doctor user.');
        }
        catch (InvalidArgumentException) {
            $this->assertDatabaseCount('doctor_working_hours', 0);
        }

        $doctor = User::factory()->doctor()->create();

        foreach ([
            ['day_of_week' => 0, 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
            ['day_of_week' => 8, 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
            ['day_of_week' => 1, 'start_time' => '13:00:00', 'end_time' => '09:00:00'],
        ] as $invalidPeriod) {
            try {
                DoctorWorkingHour::factory()->create([
                    'doctor_user_id' => $doctor->id,
                    ...$invalidPeriod,
                ]);
                $this->fail('Application persistence accepted invalid Doctor working hours.');
            }
            catch (InvalidArgumentException) {
                $this->assertDatabaseCount('doctor_working_hours', 0);
            }
        }

        $this->expectException(QueryException::class);

        DB::table('doctor_working_hours')->insert([
            'doctor_user_id' => $doctor->id,
            'day_of_week' => 1,
            'start_time' => '13:00:00',
            'end_time' => '09:00:00',
        ]);
    }

    public function test_working_hours_enforce_the_doctor_user_foreign_key(): void {
        $this->expectException(QueryException::class);

        DB::table('doctor_working_hours')->insert([
            'doctor_user_id' => 999999,
            'day_of_week' => 1,
            'start_time' => '09:00:00',
            'end_time' => '13:00:00',
        ]);
    }

    public function test_audit_logs_persist_without_an_updated_timestamp(): void {
        $actor = User::factory()->superAdministrator()->create();
        $audit = AuditLog::factory()->create([
            'actor_user_id' => $actor->id,
            'action' => 'administrative.test',
            'outcome' => 'success',
            'metadata' => ['changed_field' => 'name'],
        ]);

        $this->assertSame(['changed_field' => 'name'], $audit->metadata);
        $this->assertTrue($audit->actor->is($actor));
        $this->assertFalse(Schema::hasColumn('audit_logs', 'updated_at'));
    }

    public function test_repository_contracts_are_registered_and_perform_persistence(): void {
        $this->assertInstanceOf(RepositoryServiceProvider::class, $this->app->getProvider(RepositoryServiceProvider::class));

        $users = $this->app->make(UserRepositoryInterface::class);
        $audits = $this->app->make(AuditLogRepositoryInterface::class);

        $this->assertInstanceOf(EloquentUserRepository::class, $users);
        $this->assertInstanceOf(EloquentAuditLogRepository::class, $audits);

        $user = $users->create([
            'name' => 'Repository User',
            'email' => 'repository@example.test',
            'password' => 'plain-test-password',
            'role' => UserRole::Secretary,
        ]);
        $updated = $users->update($user, ['name' => 'Updated Repository User']);

        $this->assertTrue($users->findById($user->id)?->is($user));
        $this->assertTrue($users->findByEmail($user->email)?->is($user));
        $this->assertSame('Updated Repository User', $updated->name);

        $audit = $audits->create([
            'actor_user_id' => $user->id,
            'action' => 'repository.test',
            'outcome' => 'success',
            'metadata' => ['field' => 'name'],
        ]);

        $this->assertDatabaseHas('audit_logs', ['id' => $audit->id]);
    }

    public function test_audit_repository_rejects_sensitive_metadata_keys(): void {
        $repository = $this->app->make(AuditLogRepositoryInterface::class);

        $this->expectException(InvalidArgumentException::class);

        $repository->create([
            'action' => 'unsafe.test',
            'outcome' => 'failure',
            'metadata' => ['nested' => ['password' => 'must-not-persist']],
        ]);
    }

    public function test_initial_super_administrator_seeding_uses_configuration_and_hashes_password(): void {
        config()->set('initial_super_administrator', [
            'name' => 'Initial Administrator',
            'email' => 'initial-admin@example.test',
            'password' => 'non-sensitive-test-password',
        ]);

        $this->seed(InitialSuperAdministratorSeeder::class);

        $user = User::sole();

        $this->assertSame('Initial Administrator', $user->name);
        $this->assertSame(UserRole::SuperAdministrator, $user->role);
        $this->assertTrue(Hash::check('non-sensitive-test-password', $user->password));
        $this->assertNotSame('non-sensitive-test-password', $user->password);
    }

    public function test_initial_super_administrator_seeding_does_not_overwrite_an_existing_account(): void {
        config()->set('initial_super_administrator', [
            'name' => 'Configured Administrator',
            'email' => 'existing-user@example.test',
            'password' => 'configured-administrator-password',
        ]);
        $existingUser = User::factory()->patient()->create([
            'email' => 'existing-user@example.test',
            'password' => 'existing-user-password',
        ]);
        $existingPasswordHash = $existingUser->password;

        try {
            $this->seed(InitialSuperAdministratorSeeder::class);
            $this->fail('The unique email constraint should reject duplicate Super Administrator seeding.');
        }
        catch (QueryException) {
            // The database constraint is the intended safety boundary.
        }

        $existingUser->refresh();

        $this->assertSame(UserRole::Patient, $existingUser->role);
        $this->assertSame($existingPasswordHash, $existingUser->password);
        $this->assertTrue(Hash::check('existing-user-password', $existingUser->password));
        $this->assertDatabaseCount('users', 1);
    }
}
