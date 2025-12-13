<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicPatientsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clinic_patients')->insert([

            // =================================
            // Clinic A (clinic_id = 1)
            // patients: 1 → 7
            // =================================

            ['clinic_id'=>1, 'patient_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>6, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>1, 'patient_id'=>7, 'created_at'=>now(), 'updated_at'=>now()],


            // =================================
            // Clinic B (clinic_id = 2)
            // patients: 8 → 14
            // =================================

            ['clinic_id'=>2, 'patient_id'=>8,  'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>9,  'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>10, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>11, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>12, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>13, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>2, 'patient_id'=>14, 'created_at'=>now(), 'updated_at'=>now()],


            // =================================
            // Clinic C (clinic_id = 3)
            // patients: 15 → 20
            // =================================

            ['clinic_id'=>3, 'patient_id'=>15, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>3, 'patient_id'=>16, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>3, 'patient_id'=>17, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>3, 'patient_id'=>18, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>3, 'patient_id'=>19, 'created_at'=>now(), 'updated_at'=>now()],
            ['clinic_id'=>3, 'patient_id'=>20, 'created_at'=>now(), 'updated_at'=>now()],

        ]);
    }
}
