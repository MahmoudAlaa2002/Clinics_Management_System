<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentsSeeder extends Seeder{

    public function run(): void{

        DB::table('appointments')->insert([

            // ================================
            // CLINIC A (clinic_department: 1,2,3,4)
            // Doctors: 1 → 7
            // Patients: 1 → 7
            // ================================

            ['doctor_id'=>1,'patient_id'=>1,'clinic_department_id'=>1,'date'=>'2025-12-10','time'=>'10:00:00','status'=>'Accepted','notes'=>'General checkup','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>2,'patient_id'=>2,'clinic_department_id'=>2,'date'=>'2025-12-10','time'=>'11:00:00','status'=>'Completed','notes'=>'Dental pain','consultation_fee'=>60,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>3,'patient_id'=>3,'clinic_department_id'=>3,'date'=>'2025-12-10','time'=>'12:00:00','status'=>'Accepted','notes'=>'Bone fracture','consultation_fee'=>70,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>4,'patient_id'=>4,'clinic_department_id'=>4,'date'=>'2025-12-10','time'=>'10:30:00','status'=>'Pending','notes'=>'ENT consult','consultation_fee'=>55,'created_at'=>now(),'updated_at'=>now()],

            ['doctor_id'=>5,'patient_id'=>5,'clinic_department_id'=>1,'date'=>'2025-12-10','time'=>'13:00:00','status'=>'Accepted','notes'=>'Diabetes followup','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>6,'patient_id'=>6,'clinic_department_id'=>1,'date'=>'2025-12-10','time'=>'14:00:00','status'=>'Completed','notes'=>'Blood pressure','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],

            ['doctor_id'=>7,'patient_id'=>7,'clinic_department_id'=>2,'date'=>'2025-12-10','time'=>'15:00:00','status'=>'Pending','notes'=>'Tooth filling','consultation_fee'=>45,'created_at'=>now(),'updated_at'=>now()],


            // ================================
            // CLINIC B (clinic_department: 5,6,7,8)
            // Doctors: 32 → 41
            // Patients: 8 → 14
            // ================================

            ['doctor_id'=>11,'patient_id'=>8,'clinic_department_id'=>5,'date'=>'2025-12-06','time'=>'10:00:00','status'=>'Accepted','notes'=>'Internal check','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>12,'patient_id'=>9,'clinic_department_id'=>6,'date'=>'2025-12-06','time'=>'11:00:00','status'=>'Completed','notes'=>'Dental scaling','consultation_fee'=>60,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>13,'patient_id'=>10,'clinic_department_id'=>7,'date'=>'2025-12-06','time'=>'12:00:00','status'=>'Pending','notes'=>'Joint pain','consultation_fee'=>70,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>14,'patient_id'=>11,'clinic_department_id'=>8,'date'=>'2025-12-08','time'=>'10:30:00','status'=>'Accepted','notes'=>'ENT infection','consultation_fee'=>55,'created_at'=>now(),'updated_at'=>now()],

            ['doctor_id'=>15,'patient_id'=>12,'clinic_department_id'=>5,'date'=>'2025-12-08','time'=>'13:00:00','status'=>'Completed','notes'=>'Follow-up','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>16,'patient_id'=>13,'clinic_department_id'=>5,'date'=>'2025-12-10','time'=>'14:00:00','status'=>'Pending','notes'=>'Blood sugar','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],

            ['doctor_id'=>17,'patient_id'=>14,'clinic_department_id'=>6,'date'=>'2025-12-10','time'=>'15:00:00','status'=>'Accepted','notes'=>'Dental crown','consultation_fee'=>45,'created_at'=>now(),'updated_at'=>now()],


            // ================================
            // CLINIC C (clinic_department: 9,10)
            // Doctors: 46 → 55
            // Patients: 15 → 20
            // ================================

            ['doctor_id'=>21,'patient_id'=>15,'clinic_department_id'=>9,'date'=>'2025-12-07','time'=>'10:00:00','status'=>'Accepted','notes'=>'General consult','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>22,'patient_id'=>16,'clinic_department_id'=>9,'date'=>'2025-12-07','time'=>'11:30:00','status'=>'Pending','notes'=>'Dental pain','consultation_fee'=>60,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>23,'patient_id'=>17,'clinic_department_id'=>9,'date'=>'2025-12-09','time'=>'13:00:00','status'=>'Completed','notes'=>'Bone screening','consultation_fee'=>70,'created_at'=>now(),'updated_at'=>now()],

            ['doctor_id'=>26,'patient_id'=>18,'clinic_department_id'=>10,'date'=>'2025-12-09','time'=>'10:30:00','status'=>'Accepted','notes'=>'ENT followup','consultation_fee'=>55,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>27,'patient_id'=>19,'clinic_department_id'=>10,'date'=>'2025-12-11','time'=>'12:00:00','status'=>'Pending','notes'=>'Blood pressure','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],
            ['doctor_id'=>28,'patient_id'=>20,'clinic_department_id'=>10,'date'=>'2025-12-11','time'=>'13:30:00','status'=>'Accepted','notes'=>'Internal review','consultation_fee'=>50,'created_at'=>now(),'updated_at'=>now()],

        ]);
    }
}
