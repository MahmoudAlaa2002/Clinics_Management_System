<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1️⃣ Clinic Managers (3)
        |--------------------------------------------------------------------------
        */

        $clinicManagers = [
            ['name'=>'Clinic Manager A','email'=>'managerA@clinic.com'],
            ['name'=>'Clinic Manager B','email'=>'managerB@clinic.com'],
            ['name'=>'Clinic Manager C','email'=>'managerC@clinic.com'],
        ];

        foreach ($clinicManagers as $cm) {
            $user = User::create([
                'name' => $cm['name'],
                'email' => $cm['email'],
                'password' => Hash::make('123'),
                'phone' => '0599000001',
                'gender' => 'Male',
                'role' => 'clinic_manager',
                'date_of_birth' => '1985-01-01',
                'address' => 'Gaza',
            ]);
            $user->assignRole('clinic_manager');
        }

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Department Managers
        |--------------------------------------------------------------------------
        */

        $departmentManagers = [
            ['name'=>'Dept Manager 1','email'=>'dept1@clinic.com'],
            ['name'=>'Dept Manager 2','email'=>'dept2@clinic.com'],
            ['name'=>'Dept Manager 3','email'=>'dept3@clinic.com'],
            ['name'=>'Dept Manager 4','email'=>'dept4@clinic.com'],
            ['name'=>'Dept Manager 5','email'=>'dept5@clinic.com'],
            ['name'=>'Dept Manager 6','email'=>'dept6@clinic.com'],
            ['name'=>'Dept Manager 7','email'=>'dept7@clinic.com'],
            ['name'=>'Dept Manager 8','email'=>'dept8@clinic.com'],
        ];

        foreach ($departmentManagers as $dm) {
            $user = User::create([
                'name' => $dm['name'],
                'email' => $dm['email'],
                'password' => Hash::make('123'),
                'phone' => '0599000002',
                'gender' => 'Male',
                'role' => 'department_manager',
                'date_of_birth' => '1984-01-01',
                'address' => 'Gaza',
            ]);
            $user->assignRole('department_manager');
        }

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ Employees (Accountants + Receptionists + Nurses)
        |--------------------------------------------------------------------------
        */

        $employees = [
            ['name'=>'Accountant A','email'=>'accountantA@clinic.com'],
            ['name'=>'Accountant B','email'=>'accountantB@clinic.com'],
            ['name'=>'Accountant C','email'=>'accountantC@clinic.com'],

            ['name'=>'Reception 1','email'=>'reception1@clinic.com'],
            ['name'=>'Reception 2','email'=>'reception2@clinic.com'],
            ['name'=>'Reception 3','email'=>'reception3@clinic.com'],
            ['name'=>'Reception 4','email'=>'reception4@clinic.com'],
            ['name'=>'Reception 5','email'=>'reception5@clinic.com'],
            ['name'=>'Reception 6','email'=>'reception6@clinic.com'],
            ['name'=>'Reception 7','email'=>'reception7@clinic.com'],
            ['name'=>'Reception 8','email'=>'reception8@clinic.com'],
            ['name'=>'Reception 9','email'=>'reception9@clinic.com'],
            ['name'=>'Reception 10','email'=>'reception10@clinic.com'],

            ['name'=>'Nurse 1','email'=>'nurse1@clinic.com'],
            ['name'=>'Nurse 2','email'=>'nurse2@clinic.com'],
            ['name'=>'Nurse 3','email'=>'nurse3@clinic.com'],
            ['name'=>'Nurse 4','email'=>'nurse4@clinic.com'],
            ['name'=>'Nurse 5','email'=>'nurse5@clinic.com'],
        ];

        foreach ($employees as $emp) {
            $user = User::create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('123'),
                'phone' => '0599000003',
                'gender' => 'Female',
                'role' => 'employee',
                'date_of_birth' => '1990-01-01',
                'address' => 'Gaza',
            ]);
            $user->assignRole('employee');
        }

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ Doctors (30)
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 30; $i++) {
            $user = User::create([
                'name' => "Doctor $i",
                'email' => "doctor$i@clinic.com",
                'password' => Hash::make('123'),
                'phone' => '05991111' . $i,
                'gender' => 'Male',
                'role' => 'doctor',
                'date_of_birth' => '1980-01-01',
                'address' => 'Gaza',
            ]);
            $user->assignRole('doctor');
        }

        /*
        |--------------------------------------------------------------------------
        | 5️⃣ Patients (20)
        |--------------------------------------------------------------------------
        */

        $patients = [
            'Ahmed Hassan','Mohammed Ali','Yousef Saleh','Sarah Nabil','Mona Adel',
            'Khaled Omar','Aya Mahmoud','Nour Saeed','Sami Fares','Rania Tamer',
            'Tariq Nasser','Huda Samir','Omar Zaid','Dina Khalil','Bilal Ahmad',
            'Razan Yousef','Hani Salem','Farah Anas','Zaid Hamdan','Lina Adel',
        ];

        foreach ($patients as $index => $patient) {
            $user = User::create([
                'name' => $patient,
                'email' => 'patient'.($index+1).'@clinic.com',
                'password' => Hash::make('123'),
                'phone' => '05992222' . $index,
                'gender' => ($index % 2 == 0 ? 'Male' : 'Female'),
                'role' => 'patient',
                'date_of_birth' => '1995-01-01',
                'address' => 'Gaza',
            ]);
            $user->assignRole('patient');
        }
    }
}
