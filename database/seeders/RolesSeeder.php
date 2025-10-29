<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $clinicManager = Role::firstOrCreate(['name' => 'clinic_manager']);
        $departmentManager = Role::firstOrCreate(['name' => 'department_manager']);
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $patient = Role::firstOrCreate(['name' => 'patient']);
    }
}
