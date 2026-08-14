<?php

namespace Database\Factories;

use App\Models\DoctorWorkingHour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DoctorWorkingHour> */
class DoctorWorkingHourFactory extends Factory
{
    /** @var class-string<DoctorWorkingHour> */
    protected $model = DoctorWorkingHour::class;

    /** @return array<string, mixed> */
    public function definition(): array {
        return [
            'doctor_user_id' => User::factory()->doctor(),
            'day_of_week' => fake()->numberBetween(1, 7),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ];
    }
}
