<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'location' => $this->faker->address(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'opening_time' => '08:00:00',
            'closing_time' => '18:00:00',
            'working_days' => json_encode(['Mon','Tue','Wed','Thu','Fri']),
            'description' => $this->faker->sentence(),
            'status' => 'active',
        ];
    }
}
