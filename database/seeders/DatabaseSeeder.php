<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SpecialtySeeder::class);
        $this->call(DosageFormSeeder::class);
        $this->call(JobTitlesSeeder::class);

        // Create Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0592226120',
            'address' => 'Gaza',
            'role' => 'admin',
        ]);

        $admin->assignRole('admin');
    }
}
