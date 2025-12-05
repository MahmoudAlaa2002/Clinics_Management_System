<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0592226120',
            'address' => 'Gaza',
            'date_of_birth' => '2002-03-13',
            'image' => 'assets/img/admin/admin.jpg',
            'gender' => 'male',
            'role' => 'admin',   // using role from users table
        ]);

        // Create Doctor user
        $doctor = User::create([
            'name' => 'Dr. Ahmed',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0591234567',
            'address' => 'Gaza',
            'date_of_birth' => '1990-05-10',
            'image' => 'assets/img/doctors/doctor.jpg',
            'gender' => 'male',
            'role' => 'doctor',   // using role from users table
        ]);

        // Factories
        \App\Models\User::factory(10)->create();
        \App\Models\Clinic::factory(5)->create();
        \App\Models\Department::factory(5)->create();
        \App\Models\ClinicDepartment::factory(10)->create();
        \App\Models\Employee::factory(10)->create();
        \App\Models\Doctor::factory(10)->create();
        \App\Models\Patient::factory(20)->create();
        \App\Models\Appointment::factory(30)->create();
        \App\Models\Invoice::factory(30)->create();
        \App\Models\MedicalRecord::factory(30)->create();

        $this->call(DepartmentSeeder::class);
    }
}
