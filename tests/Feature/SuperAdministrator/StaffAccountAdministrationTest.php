<?php

namespace Tests\Feature\SuperAdministrator;

use App\Models\User;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class StaffAccountAdministrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_administrator_creates_a_doctor_with_a_fixed_role_and_a_safe_response(): void {
        $administrator = User::factory()->superAdministrator()->create();

        $response = $this->withToken($this->tokenFor($administrator))->postJson(
            '/api/super-administrator/doctors',
            [
                'name' => 'Doctor Account',
                'email' => 'doctor@example.com',
                'password' => 'doctor-password',
                'password_confirmation' => 'doctor-password',
                'role' => UserRole::SuperAdministrator->value,
            ],
        );

        $response
            ->assertCreated()
            ->assertExactJson([
                'success' => true,
                'status_code' => 201,
                'message' => 'Doctor account created successfully.',
                'data' => [
                    'id' => $response->json('data.id'),
                    'name' => 'Doctor Account',
                    'email' => 'doctor@example.com',
                    'role' => UserRole::Doctor->value,
                ],
            ]);

        $doctor = User::where('email', 'doctor@example.com')->sole();

        $this->assertSame(UserRole::Doctor, $doctor->role);
        $this->assertTrue(Hash::check('doctor-password', $doctor->password));
        $this->assertStringNotContainsString('doctor-password', (string) $response->getContent());
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $administrator->id,
            'action' => 'doctor_account.created',
            'subject_type' => User::class,
            'subject_id' => $doctor->id,
            'outcome' => 'success',
        ]);
    }

    public function test_super_administrator_creates_a_secretary_with_a_fixed_role_and_hashed_password(): void {
        $administrator = User::factory()->superAdministrator()->create();

        $response = $this->withToken($this->tokenFor($administrator))->postJson(
            '/api/super-administrator/secretaries',
            [
                'name' => 'Secretary Account',
                'email' => 'secretary@example.com',
                'password' => 'secretary-password',
                'password_confirmation' => 'secretary-password',
                'role' => UserRole::Doctor->value,
            ],
        );

        $response
            ->assertCreated()
            ->assertJsonPath('data.role', UserRole::Secretary->value)
            ->assertJsonMissingPath('data.password');

        $secretary = User::where('email', 'secretary@example.com')->sole();

        $this->assertSame(UserRole::Secretary, $secretary->role);
        $this->assertTrue(Hash::check('secretary-password', $secretary->password));
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $administrator->id,
            'action' => 'secretary_account.created',
            'subject_id' => $secretary->id,
            'outcome' => 'success',
        ]);
    }

    public function test_creation_validates_required_fields_confirmation_and_unique_email(): void {
        $administrator = User::factory()->superAdministrator()->create();
        User::factory()->doctor()->create(['email' => 'existing@example.com']);
        $token = $this->tokenFor($administrator);

        $this->withToken($token)
            ->postJson('/api/super-administrator/doctors', [])
            ->assertUnprocessable()
            ->assertJsonPath('error_code', 'VALIDATION_ERROR')
            ->assertJsonValidationErrors(['name', 'email', 'password']);

        $this->withToken($token)
            ->postJson('/api/super-administrator/secretaries', [
                'name' => 'Duplicate Account',
                'email' => 'existing@example.com',
                'password' => 'password-one',
                'password_confirmation' => 'different-password',
            ])
            ->assertUnprocessable()
            ->assertJsonPath('error_code', 'VALIDATION_ERROR')
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_super_administrator_edits_a_doctor_without_changing_role_or_password(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $doctor = User::factory()->doctor()->create(['password' => 'original-password']);

        $this->withToken($this->tokenFor($administrator))
            ->patchJson("/api/super-administrator/doctors/{$doctor->id}", [
                'name' => 'Updated Doctor',
                'email' => 'updated-doctor@example.com',
                'role' => UserRole::SuperAdministrator->value,
                'password' => 'malicious-password',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Doctor')
            ->assertJsonPath('data.email', 'updated-doctor@example.com')
            ->assertJsonPath('data.role', UserRole::Doctor->value)
            ->assertJsonMissingPath('data.password');

        $doctor->refresh();
        $this->assertSame(UserRole::Doctor, $doctor->role);
        $this->assertTrue(Hash::check('original-password', $doctor->password));
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $administrator->id,
            'action' => 'doctor_account.updated',
            'subject_id' => $doctor->id,
            'outcome' => 'success',
        ]);
    }

    public function test_super_administrator_edits_a_secretary_with_only_an_approved_field(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $secretary = User::factory()->secretary()->create();

        $this->withToken($this->tokenFor($administrator))
            ->patchJson("/api/super-administrator/secretaries/{$secretary->id}", [
                'name' => 'Updated Secretary',
                'role' => UserRole::Patient->value,
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Secretary')
            ->assertJsonPath('data.role', UserRole::Secretary->value);

        $this->assertSame(UserRole::Secretary, $secretary->refresh()->role);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'secretary_account.updated',
            'subject_id' => $secretary->id,
            'outcome' => 'success',
        ]);
    }

    public function test_updates_require_at_least_one_editable_field_and_a_unique_email(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $doctor = User::factory()->doctor()->create();
        $existing = User::factory()->secretary()->create();
        $token = $this->tokenFor($administrator);

        $this->withToken($token)
            ->patchJson("/api/super-administrator/doctors/{$doctor->id}", [
                'role' => UserRole::Patient->value,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email']);

        $this->withToken($token)
            ->patchJson("/api/super-administrator/doctors/{$doctor->id}", [
                'email' => $existing->email,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    #[DataProvider('nonAdministratorRoleProvider')]
    public function test_non_administrator_roles_cannot_administer_staff(string $factoryState): void {
        $user = User::factory()->{$factoryState}()->create();

        $this->withToken($this->tokenFor($user))
            ->postJson('/api/super-administrator/doctors', [
                'name' => 'Forbidden Doctor',
                'email' => 'forbidden@example.com',
                'password' => 'forbidden-password',
                'password_confirmation' => 'forbidden-password',
            ])
            ->assertForbidden()
            ->assertJsonPath('error_code', 'FORBIDDEN');
    }

    public function test_unauthenticated_staff_administration_is_rejected(): void {
        $this->postJson('/api/super-administrator/secretaries', [
            'name' => 'Unauthenticated Secretary',
            'email' => 'unauthenticated@example.com',
            'password' => 'password-value',
            'password_confirmation' => 'password-value',
        ])
            ->assertUnauthorized()
            ->assertJsonPath('error_code', 'UNAUTHENTICATED');
    }

    public function test_missing_or_wrong_role_staff_targets_return_the_standard_not_found_response(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $secretary = User::factory()->secretary()->create();
        $token = $this->tokenFor($administrator);

        $this->withToken($token)
            ->patchJson('/api/super-administrator/doctors/999999', ['name' => 'Missing'])
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');

        $this->withToken($token)
            ->patchJson("/api/super-administrator/doctors/{$secretary->id}", ['name' => 'Wrong Role'])
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    public function test_secretary_update_returns_not_found_for_a_doctor_target(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $doctor = User::factory()->doctor()->create();

        $this->withToken($this->tokenFor($administrator))
            ->patchJson("/api/super-administrator/secretaries/{$doctor->id}", [
                'name' => 'Wrong Role Target',
            ])
            ->assertNotFound()
            ->assertJsonPath('error_code', 'RESOURCE_NOT_FOUND');
    }

    public function test_account_creation_rolls_back_when_audit_persistence_fails(): void {
        $administrator = User::factory()->superAdministrator()->create();
        $audits = Mockery::mock(AuditLogRepositoryInterface::class);
        $audits->shouldReceive('create')->once()->andThrow(new RuntimeException('audit failure'));
        $this->app->instance(AuditLogRepositoryInterface::class, $audits);

        $this->withToken($this->tokenFor($administrator))
            ->postJson('/api/super-administrator/doctors', [
                'name' => 'Rolled Back Doctor',
                'email' => 'rollback@example.com',
                'password' => 'rollback-password',
                'password_confirmation' => 'rollback-password',
            ])
            ->assertInternalServerError()
            ->assertJsonPath('error_code', 'INTERNAL_SERVER_ERROR');

        $this->assertDatabaseMissing('users', ['email' => 'rollback@example.com']);
        $this->assertDatabaseCount('audit_logs', 0);
    }

    public static function nonAdministratorRoleProvider(): array {
        return [
            'patient' => ['patient'],
            'doctor' => ['doctor'],
            'secretary' => ['secretary'],
        ];
    }

    private function tokenFor(User $user): string {
        return $user->createToken('staff-administration-test')->plainTextToken;
    }
}
