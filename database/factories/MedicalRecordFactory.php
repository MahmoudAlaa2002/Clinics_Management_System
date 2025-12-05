<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => \App\Models\Appointment::inRandomOrder()->first()->id,
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()->id,
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()->id,
            'diagnosis' => $this->faker->sentence(),
            'treatment' => $this->faker->sentence(),
            'record_date' => $this->faker->date(),
            'prescriptions' => $this->faker->text(50),
            'attachments' => null,
            'notes' => $this->faker->text(50),
        ];
    }
}
