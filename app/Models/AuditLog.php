<?php

namespace App\Models;

use Database\Factories\AuditLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'actor_user_id',
        'action',
        'subject_type',
        'subject_id',
        'outcome',
        'metadata',
        'ip_address',
    ];

    protected static function newFactory(): AuditLogFactory {
        return AuditLogFactory::new();
    }

    public function actor(): BelongsTo {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    protected function casts(): array {
        return [
            'metadata' => 'array',
        ];
    }
}
