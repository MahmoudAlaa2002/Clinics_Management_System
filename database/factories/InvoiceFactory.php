<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => \App\Models\Appointment::factory(),
            'patient_id' => \App\Models\Patient::factory(),
            'total_amount' => $this->faker->randomFloat(2, 20, 200),
            'payment_status' => $this->faker->randomElement(['Paid', 'Partially Paid', 'Unpaid']),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
        ];
    }
}
