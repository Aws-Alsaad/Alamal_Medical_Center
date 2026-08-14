<?php

namespace App\Shared\Audit\Repositories\Contracts;

use App\Models\AuditLog;

interface AuditLogRepositoryInterface
{
    public function create(array $attributes): AuditLog;
}
