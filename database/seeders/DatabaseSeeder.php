<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DepartmentSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{
        // $this->call(RolesSeeder::class);
        // $this->call(DepartmentSeeder::class);

        // // Create Admin user
        // $admin = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('123456'),
        //     'phone' => '0592226120',
        //     'address' => 'Gaza',
        //     'date_of_birth' => '2002-03-13',
        //     'image' => 'assets/img/admin/admin.jpg',
        //     'gender' => 'male',
        //     'role' => 'admin',
        // ]);

        // Role::firstOrCreate([
        //     'name' => 'admin',
        //     'guard_name' => 'web',
        // ]);

        // $admin->assignRole('admin');

        // // Create Doctor user
        // $doctor = User::create([
        //     'name' => 'Dr. Ahmed',
        //     'email' => 'doctor@gmail.com',
        //     'password' => Hash::make('123456'),
        //     'phone' => '0591234567',
        //     'address' => 'Gaza',
        //     'date_of_birth' => '1990-05-10',
        //     'image' => 'assets/img/doctors/doctor.jpg',
        //     'gender' => 'male',
        //     'role' => 'doctor',
        // ]);

        // // Create doctor role if it doesn't exist
        // Role::firstOrCreate([
        //     'name' => 'doctor',
        //     'guard_name' => 'web',
        // ]);

        // // Assign role to the doctor user
        // $doctor->assignRole('doctor');

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


    }
}
