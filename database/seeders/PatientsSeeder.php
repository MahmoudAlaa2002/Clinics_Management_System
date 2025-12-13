<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsSeeder extends Seeder{

    public function run(): void{

        DB::table('patients')->insert([

            // ==============================
            // Patients (user_id: 57 → 76)
            // ==============================

            ['user_id'=>61,'blood_type'=>'A+','emergency_contact'=>'0599111111','allergies'=>'None','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>62,'blood_type'=>'O+','emergency_contact'=>'0599222222','allergies'=>'Penicillin','chronic_diseases'=>'Asthma','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>63,'blood_type'=>'B+','emergency_contact'=>'0599333333','allergies'=>'Dust','chronic_diseases'=>'Diabetes','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>64,'blood_type'=>'AB+','emergency_contact'=>'0599444444','allergies'=>'Seafood','chronic_diseases'=>'Hypertension','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>65,'blood_type'=>'A-','emergency_contact'=>'0599555555','allergies'=>'None','chronic_diseases'=>'Migraine','created_at'=>now(),'updated_at'=>now()],

            ['user_id'=>66,'blood_type'=>'O-','emergency_contact'=>'0599666666','allergies'=>'Latex','chronic_diseases'=>'Heart Disease','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>67,'blood_type'=>'B-','emergency_contact'=>'0599777777','allergies'=>'Pollen','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>68,'blood_type'=>'AB-','emergency_contact'=>'0599888888','allergies'=>'Eggs','chronic_diseases'=>'Thyroid','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>69,'blood_type'=>'A+','emergency_contact'=>'0599999999','allergies'=>'Milk','chronic_diseases'=>'Anemia','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>70,'blood_type'=>'O+','emergency_contact'=>'0599000000','allergies'=>'None','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],

            ['user_id'=>71,'blood_type'=>'B+','emergency_contact'=>'0599112233','allergies'=>'Peanuts','chronic_diseases'=>'Epilepsy','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>72,'blood_type'=>'AB+','emergency_contact'=>'0599223344','allergies'=>'None','chronic_diseases'=>'Kidney Disease','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>73,'blood_type'=>'A-','emergency_contact'=>'0599334455','allergies'=>'Dust','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>74,'blood_type'=>'O-','emergency_contact'=>'0599445566','allergies'=>'Seafood','chronic_diseases'=>'Arthritis','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>75,'blood_type'=>'B-','emergency_contact'=>'0599556677','allergies'=>'None','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],

            ['user_id'=>76,'blood_type'=>'AB-','emergency_contact'=>'0599667788','allergies'=>'Penicillin','chronic_diseases'=>'Hypertension','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>77,'blood_type'=>'A+','emergency_contact'=>'0599778899','allergies'=>'None','chronic_diseases'=>'Diabetes','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>78,'blood_type'=>'O+','emergency_contact'=>'0599889900','allergies'=>'Pollen','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>79,'blood_type'=>'B+','emergency_contact'=>'0599001122','allergies'=>'Milk','chronic_diseases'=>'Asthma','created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>80,'blood_type'=>'AB+','emergency_contact'=>'0599112234','allergies'=>'None','chronic_diseases'=>'None','created_at'=>now(),'updated_at'=>now()],

        ]);
    }
}
