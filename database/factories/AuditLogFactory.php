<?php

namespace Database\Factories;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AuditLog> */
class AuditLogFactory extends Factory
{
    /** @var class-string<AuditLog> */
    protected $model = AuditLog::class;

    /** @return array<string, mixed> */
    public function definition(): array {
        return [
            'actor_user_id' => null,
            'action' => 'test.action',
            'subject_type' => null,
            'subject_id' => null,
            'outcome' => 'success',
            'metadata' => null,
            'ip_address' => fake()->ipv4(),
        ];
    }
}
