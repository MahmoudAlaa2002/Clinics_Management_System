<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        DB::table('job_titles')->insert([
            ['name' => 'Clinic Manager'     , 'need_department' => 0  , 'need_doctor' => 0],
            ['name' => 'Department Manager' , 'need_department' => 1  , 'need_doctor' => 0],
            ['name' => 'Doctor'             , 'need_department' => 1  , 'need_doctor' => 0],
            ['name' => 'Receptionist'       , 'need_department' => 1  , 'need_doctor' => 1],
            ['name' => 'Nurse'              , 'need_department' => 1  , 'need_doctor' => 1],
            ['name' => 'Accountant'         , 'need_department' => 0  , 'need_doctor' => 0],
            ['name' => 'Pharmacist'         , 'need_department' => 0  , 'need_doctor' => 0],
            ['name' => 'Store Supervisor'   , 'need_department' => 0  , 'need_doctor' => 0],
        ]);
    }
}
