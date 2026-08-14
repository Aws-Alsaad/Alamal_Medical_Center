<?php

namespace Tests\Feature\Shared;

use App\Models\AuditLog;
use App\Models\User;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('roleProvider')]
    public function test_each_role_can_log_in_through_its_own_entry_point(
        UserRole $role,
        string $factoryState,
        string $prefix,
    ): void {
        $user = User::factory()->{$factoryState}()->create([
            'name' => 'Approved User',
            'password' => 'valid-password',
        ]);

        $response = $this->postJson("/api/{$prefix}/auth/login", [
            'email' => $user->email,
            'password' => 'valid-password',
        ]);

        $response
            ->assertOk()
            ->assertExactJsonStructure([
                'success',
                'status_code',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'role'],
                    'token',
                    'token_type',
                ],
            ])
            ->assertJsonPath('success', true)
            ->assertJsonPath('status_code', 200)
            ->assertJsonPath('data.user.id', $user->id)
            ->assertJsonPath('data.user.name', 'Approved User')
            ->assertJsonPath('data.user.role', $role->value)
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonMissingPath('data.user.email')
            ->assertJsonMissingPath('data.user.password');

        $this->assertIsString($response->json('data.token'));
        $this->assertDatabaseCount('personal_access_tokens', 1);
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $user->id,
            'action' => 'authentication.login',
            'outcome' => 'success',
        ]);
    }

    public function test_invalid_credentials_return_the_approved_error_and_create_no_token(): void {
        $user = User::factory()->patient()->create(['password' => 'valid-password']);

        $this->postJson('/api/patient/auth/login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])
            ->assertUnauthorized()
            ->assertExactJson([
                'success' => false,
                'status_code' => 401,
                'message' => 'The provided credentials are invalid.',
                'error_code' => 'INVALID_CREDENTIALS',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
        $audit = AuditLog::sole();
        $this->assertSame($user->id, $audit->actor_user_id);
        $this->assertSame('failure', $audit->outcome);
        $this->assertSame(['reason' => 'invalid_credentials'], $audit->metadata);
        $this->assertStringNotContainsString('incorrect-password', $audit->toJson());
    }

    public function test_unknown_identity_failed_login_is_audited_without_sensitive_metadata(): void {
        $submittedPassword = 'unknown-user-password-value';

        $this->postJson('/api/patient/auth/login', [
            'email' => 'unknown-user@example.test',
            'password' => $submittedPassword,
        ])
            ->assertUnauthorized()
            ->assertJsonPath('error_code', 'INVALID_CREDENTIALS');

        $this->assertDatabaseCount('personal_access_tokens', 0);
        $this->assertDatabaseCount('audit_logs', 1);

        $audit = AuditLog::sole();
        $metadata = json_encode($audit->metadata, JSON_THROW_ON_ERROR);

        $this->assertNull($audit->actor_user_id);
        $this->assertSame('authentication.login', $audit->action);
        $this->assertSame('failure', $audit->outcome);
        $this->assertSame(['reason' => 'invalid_credentials'], $audit->metadata);
        $this->assertStringNotContainsString($submittedPassword, $metadata);
        $this->assertStringNotContainsString('token', strtolower($metadata));
        $this->assertStringNotContainsString('secret', strtolower($metadata));
    }

    #[DataProvider('roleMismatchProvider')]
    public function test_each_role_is_rejected_by_another_roles_login_entry_point(
        string $factoryState,
        string $wrongPrefix,
    ): void {
        $user = User::factory()->{$factoryState}()->create(['password' => 'valid-password']);

        $this->postJson("/api/{$wrongPrefix}/auth/login", [
            'email' => $user->email,
            'password' => 'valid-password',
        ])
            ->assertForbidden()
            ->assertExactJson([
                'success' => false,
                'status_code' => 403,
                'message' => 'The credentials do not match the requested role.',
                'error_code' => 'ROLE_MISMATCH',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $user->id,
            'action' => 'authentication.login',
            'outcome' => 'failure',
        ]);
    }

    public function test_login_validation_uses_the_standard_error_contract(): void {
        $this->postJson('/api/patient/auth/login', [
            'email' => 'not-an-email',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status_code', 422)
            ->assertJsonPath('error_code', 'VALIDATION_ERROR')
            ->assertJsonValidationErrors(['email', 'password']);
    }

    #[DataProvider('roleProvider')]
    public function test_role_protected_authentication_routes_require_a_token(
        UserRole $role,
        string $factoryState,
        string $prefix,
    ): void {
        $this->postJson("/api/{$prefix}/auth/logout")
            ->assertUnauthorized()
            ->assertJsonPath('error_code', 'UNAUTHENTICATED');

        $this->patchJson("/api/{$prefix}/auth/password", [
            'current_password' => 'current-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
            ->assertUnauthorized()
            ->assertJsonPath('error_code', 'UNAUTHENTICATED');
    }

    #[DataProvider('roleBoundaryProvider')]
    public function test_authenticated_users_cannot_cross_role_boundaries(
        string $factoryState,
        string $wrongPrefix,
    ): void {
        $user = User::factory()->{$factoryState}()->create();
        $token = $user->createToken('boundary-test')->plainTextToken;

        $this->withToken($token)
            ->patchJson("/api/{$wrongPrefix}/auth/password", [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertForbidden()
            ->assertExactJson([
                'success' => false,
                'status_code' => 403,
                'message' => 'You are not authorized to perform this action.',
                'error_code' => 'FORBIDDEN',
            ]);
    }

    public function test_logout_revokes_only_the_current_token_and_audits_the_event(): void {
        $user = User::factory()->patient()->create();
        $currentToken = $user->createToken('current-token');
        $otherToken = $user->createToken('other-token');

        $this->withToken($currentToken->plainTextToken)
            ->postJson('/api/patient/auth/logout')
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Logged out successfully.',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $currentToken->accessToken->id]);
        $this->assertDatabaseHas('personal_access_tokens', ['id' => $otherToken->accessToken->id]);
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $user->id,
            'action' => 'authentication.logout',
            'outcome' => 'success',
        ]);

        Auth::forgetGuards();

        $this->withToken($currentToken->plainTextToken)
            ->postJson('/api/patient/auth/logout')
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_change_password(): void {
        $user = User::factory()->doctor()->create(['password' => 'current-password']);
        $token = $user->createToken('password-change')->plainTextToken;

        $this->withToken($token)
            ->patchJson('/api/doctor/auth/password', [
                'current_password' => 'current-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertOk()
            ->assertExactJson([
                'success' => true,
                'status_code' => 200,
                'message' => 'Password changed successfully.',
                'data' => null,
            ]);

        $user->refresh();
        $this->assertTrue(Hash::check('new-password', $user->password));
        $this->assertFalse(Hash::check('current-password', $user->password));
        $this->assertDatabaseHas('audit_logs', [
            'actor_user_id' => $user->id,
            'action' => 'authentication.password_changed',
            'outcome' => 'success',
        ]);

        $this->postJson('/api/doctor/auth/login', [
            'email' => $user->email,
            'password' => 'current-password',
        ])->assertUnauthorized();

        $this->postJson('/api/doctor/auth/login', [
            'email' => $user->email,
            'password' => 'new-password',
        ])->assertOk();
    }

    public function test_password_change_rejects_incorrect_current_password_and_confirmation(): void {
        $user = User::factory()->secretary()->create(['password' => 'current-password']);
        $token = $user->createToken('password-change')->plainTextToken;

        $this->withToken($token)
            ->patchJson('/api/secretary/auth/password', [
                'current_password' => 'incorrect-password',
                'password' => 'new-password',
                'password_confirmation' => 'different-password',
            ])
            ->assertUnprocessable()
            ->assertJsonPath('error_code', 'VALIDATION_ERROR')
            ->assertJsonValidationErrors(['current_password', 'password']);

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));
        $this->assertDatabaseMissing('audit_logs', [
            'action' => 'authentication.password_changed',
        ]);
    }

    public static function roleProvider(): array {
        return [
            'Patient' => [UserRole::Patient, 'patient', 'patient'],
            'Doctor' => [UserRole::Doctor, 'doctor', 'doctor'],
            'Secretary' => [UserRole::Secretary, 'secretary', 'secretary'],
            'Super Administrator' => [UserRole::SuperAdministrator, 'superAdministrator', 'super-administrator'],
        ];
    }

    public static function roleMismatchProvider(): array {
        return [
            'Patient through Doctor' => ['patient', 'doctor'],
            'Doctor through Secretary' => ['doctor', 'secretary'],
            'Secretary through Super Administrator' => ['secretary', 'super-administrator'],
            'Super Administrator through Patient' => ['superAdministrator', 'patient'],
        ];
    }

    public static function roleBoundaryProvider(): array {
        return [
            'Patient to Doctor' => ['patient', 'doctor'],
            'Doctor to Secretary' => ['doctor', 'secretary'],
            'Secretary to Super Administrator' => ['secretary', 'super-administrator'],
            'Super Administrator to Patient' => ['superAdministrator', 'patient'],
        ];
    }
}
