<?php

namespace Tests\Unit\Shared\Identity;

use App\Shared\Identity\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_it_contains_only_the_four_approved_roles(): void {
        $this->assertSame([
            'patient',
            'doctor',
            'secretary',
            'super_administrator',
        ], array_column(UserRole::cases(), 'value'));
    }
}
