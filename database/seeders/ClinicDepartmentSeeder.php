<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClinicDepartmentSeeder extends Seeder{

    public function run(): void{
        DB::table('clinic_departments')->insert([

            // Clinic A (id = 1)
            ['clinic_id'=> 1, 'department_id'=> 1, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 2, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 7, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 1, 'department_id'=> 8, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],



            // Clinic B (id = 2)
            ['clinic_id'=> 2, 'department_id'=> 3, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 5, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 6, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 2, 'department_id'=> 13,'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],



            // Clinic C (id = 3)
            ['clinic_id'=> 3, 'department_id'=> 1, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['clinic_id'=> 3, 'department_id'=> 15, 'status' => 'active' , 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ]);
    }
}
