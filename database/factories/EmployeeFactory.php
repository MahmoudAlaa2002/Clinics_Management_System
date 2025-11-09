<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'clinic_id' => \App\Models\Clinic::factory(),
            'department_id' => \App\Models\Department::inRandomOrder()->first()->id,
            'job_title' => $this->faker->jobTitle(),
            'work_start_time' => '09:00:00',
            'work_end_time' => '17:00:00',
            'working_days' => json_encode(['Mon','Tue','Wed','Thu','Fri']),
            'hire_date' => $this->faker->date(),
            'status' => 'active',
            'short_biography' => $this->faker->paragraph(),
        ];
    }
}
