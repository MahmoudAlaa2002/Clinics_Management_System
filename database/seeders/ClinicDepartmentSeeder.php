<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClinicDepartmentSeeder extends Seeder{

    public function run(): void{
        DB::table('clinic_departments')->insert([

            // Clinic A (id = 1)
            ['clinic_id'=> 1, 'department_id'=> 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],



            // Clinic B (id = 2)
            ['clinic_id'=> 2, 'department_id'=> 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],



            // Clinic C (id = 3)
            ['clinic_id'=> 3, 'department_id'=> 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 3, 'department_id'=> 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ]);
    }
}
