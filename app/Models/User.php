<?php

namespace App\Models;

use App\Shared\Identity\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function newFactory(): UserFactory {
        return UserFactory::new();
    }

    public function workingHours(): HasMany {
        return $this->hasMany(DoctorWorkingHour::class, 'doctor_user_id');
    }

    public function auditLogs(): HasMany {
        return $this->hasMany(AuditLog::class, 'actor_user_id');
    }

    protected function casts(): array {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }
}
