<?php

namespace Database\Factories;

use App\Models\MedicalService;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MedicalService> */
class MedicalServiceFactory extends Factory
{
    /** @var class-string<MedicalService> */
    protected $model = MedicalService::class;

    /** @return array<string, mixed> */
    public function definition(): array {
        return [
            'name' => fake()->unique()->words(3, true),
            'cost' => fake()->randomFloat(2, 0, 999999.99),
        ];
    }
}
