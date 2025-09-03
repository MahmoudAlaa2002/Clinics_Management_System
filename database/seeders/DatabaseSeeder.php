<?php

namespace Database\Seeders;


use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DosageFormSeeder::class);
        $this->call(JobTitlesSeeder::class);

        // Create Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0592226120',
            'address' => 'Gaza',
            'date_of_birth' => '2002-03-13',
            'gender' => 'male',
        ]);

        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->assignRole('admin');
    }
}
