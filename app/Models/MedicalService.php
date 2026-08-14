<?php

namespace App\Models;

use Database\Factories\MedicalServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class MedicalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
    ];

    protected static function newFactory(): MedicalServiceFactory {
        return MedicalServiceFactory::new();
    }

    protected static function booted(): void {
        static::saving(function (self $medicalService): void {
            if ((float) $medicalService->cost < 0) {
                throw new InvalidArgumentException('Medical service cost must not be negative.');
            }
        });
    }

    protected function casts(): array {
        return [
            'cost' => 'decimal:2',
        ];
    }
}
