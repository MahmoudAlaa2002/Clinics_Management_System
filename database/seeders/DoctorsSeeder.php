<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsSeeder extends Seeder{

    public function run(): void{

        DB::table('doctors')->insert([

            // ==============================
            // CLINIC A  (employee_id: 13 → 22)
            // ==============================

            ['employee_id'=>13,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>14,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>15,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>70 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>16,'speciality'=>'ENT'               ,'qualification'=>'BDS'   ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>17,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],

            ['employee_id'=>18,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS'   ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>19,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>45 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>20,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>65 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>21,'speciality'=>'ENT'               ,'qualification'=>'BDS' ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>22,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD'   ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],


            // ==============================
            // CLINIC B  (employee_id: 31 → 40)
            // ==============================

            ['employee_id'=>35,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>36,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>37,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>70 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>38,'speciality'=>'ENT'               ,'qualification'=>'BDS'   ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>39,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],

            ['employee_id'=>40,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS'   ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>41,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>45 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>42,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>65 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>43,'speciality'=>'ENT'               ,'qualification'=>'BDS' ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>44,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD'   ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],


            // ==============================
            // CLINIC C  (employee_id: 45 → 54)
            // ==============================

            ['employee_id'=>49,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>50,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>51,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>70 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>52,'speciality'=>'ENT'               ,'qualification'=>'BDS'   ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>53,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD' ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],

            ['employee_id'=>54,'speciality'=>'Internal Medicine' ,'qualification'=>'MBBS'   ,'consultation_fee'=>50 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>55,'speciality'=>'Dentistry'         ,'qualification'=>'MD'  ,'consultation_fee'=>45 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>56,'speciality'=>'Orthopedics'       ,'qualification'=>'DO' ,'consultation_fee'=>65 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>57,'speciality'=>'ENT'               ,'qualification'=>'BDS' ,'consultation_fee'=>55 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],
            ['employee_id'=>58,'speciality'=>'Internal Medicine' ,'qualification'=>'PhD'   ,'consultation_fee'=>60 ,'rating'=>4,'created_at'=>now(),'updated_at'=>now()],

        ]);
    }
}
