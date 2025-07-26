<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'General Medicine',
            'Pediatrics',
            'Obstetrics',
            'Internal Medicine',
            'General Surgery',
            'Dentistry',
            'Orthopedics',
            'Ophthalmology',
            'ENT (Otolaryngology)',
            'Dermatology',
            'Cardiology',
            'Urology',
        ];

        foreach ($specialties as $name) {
            Specialty::firstOrCreate(
                ['name' => $name],
                ['description' => 'No description is available for this specialty yet.']
            );
        }
    }
}
