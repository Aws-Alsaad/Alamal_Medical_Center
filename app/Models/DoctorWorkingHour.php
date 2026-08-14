<?php

namespace App\Models;

use App\Shared\Identity\Enums\UserRole;
use Database\Factories\DoctorWorkingHourFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class DoctorWorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_user_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    protected static function newFactory(): DoctorWorkingHourFactory {
        return DoctorWorkingHourFactory::new();
    }

    protected static function booted(): void {
        static::saving(function (self $workingHour): void {
            if ((int) $workingHour->day_of_week < 1 || (int) $workingHour->day_of_week > 7) {
                throw new InvalidArgumentException('Day of week must be between 1 and 7.');
            }

            if ((string) $workingHour->end_time <= (string) $workingHour->start_time) {
                throw new InvalidArgumentException('Working-hour end time must be later than start time.');
            }

            $doctor = User::find($workingHour->doctor_user_id);

            if (! $doctor || $doctor->role !== UserRole::Doctor) {
                throw new InvalidArgumentException('Doctor working hours must reference a Doctor user.');
            }
        });
    }

    public function doctor(): BelongsTo {
        return $this->belongsTo(User::class, 'doctor_user_id');
    }

    protected function casts(): array {
        return [
            'day_of_week' => 'integer',
        ];
    }
}
