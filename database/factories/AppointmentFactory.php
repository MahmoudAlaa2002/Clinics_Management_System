<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()->id,
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()->id,
            'clinic_department_id' => \App\Models\ClinicDepartment::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'time' => $this->faker->time('H:i:s'),
            'status' => $this->faker->randomElement(['Pending','Accepted','Rejected','Cancelled','Completed']),
            'notes' => $this->faker->sentence(),
            'consultation_fee' => \App\Models\Doctor::inRandomOrder()->first()->consultation_fee,
        ];
    }
}
