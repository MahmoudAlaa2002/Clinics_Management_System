<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void{
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
            'Nutrition',
            'Psychology',
        ];

        foreach ($specialties as $name) {
            Department::firstOrCreate(
                ['name' => $name],
                ['description' => 'No description is available for this specialty yet.']
            );
        }
    }
}
