<?php

namespace App\Shared\Audit\Repositories\Eloquent;

use App\Models\AuditLog;
use App\Shared\Audit\Repositories\Contracts\AuditLogRepositoryInterface;
use InvalidArgumentException;

class EloquentAuditLogRepository implements AuditLogRepositoryInterface
{
    private const SENSITIVE_METADATA_KEYS = [
        'password',
        'password_confirmation',
        'password_hash',
        'token',
        'access_token',
        'api_key',
        'secret',
    ];

    public function create(array $attributes): AuditLog {
        $metadata = $attributes['metadata'] ?? null;

        if (is_array($metadata)) {
            $this->assertMetadataContainsNoSecretKeys($metadata);
        }

        return AuditLog::create($attributes);
    }

    private function assertMetadataContainsNoSecretKeys(array $metadata): void {
        foreach ($metadata as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), self::SENSITIVE_METADATA_KEYS, true)) {
                throw new InvalidArgumentException("Audit metadata must not contain the sensitive key [{$key}].");
            }

            if (is_array($value)) {
                $this->assertMetadataContainsNoSecretKeys($value);
            }
        }
    }
}
