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
        $this->call(RolesSeeder::class);
        $this->call(DepartmentSeeder::class);


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
            'role' => 'admin',
        ]);

        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->assignRole('admin');







        //Test
        $this->call(ClinicsSeeder::class);
        $this->call(ClinicDepartmentSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(EmployeesSeeder::class);
        $this->call(DoctorsSeeder::class);
        $this->call(PatientsSeeder::class);
        $this->call(ClinicPatientsSeeder::class);
        $this->call(AppointmentsSeeder::class);
        $this->call(InvoicesSeeder::class);
        $this->call(MedicalRecordsSeeder::class);




    }
}
