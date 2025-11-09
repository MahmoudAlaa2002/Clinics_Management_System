<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => \App\Models\Employee::factory(),
            'speciality' => $this->faker->word(),
            'qualification' => $this->faker->sentence(3),
            'consultation_fee' => $this->faker->randomFloat(2, 20, 100),
            'rating' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}
