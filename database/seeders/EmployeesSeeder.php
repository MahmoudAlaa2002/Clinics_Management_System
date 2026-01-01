<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeesSeeder extends Seeder{

    public function run(): void{
        $Clinic_A_Days   = json_encode(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday']);
        $Clinic_B_Days   = json_encode(['Saturday','Monday','Wednesday']);
        $Clinic_C_Days   = json_encode(['Sunday','Tuesday','Thursday']);

        DB::table('employees')->insert([

        // ====================================================
        // CLINIC A  (08:00 → 20:00)
        // Departments: 1, 2, 7, 8
        // ====================================================

        // مدير عيادة
        [
            'user_id'=>2,'clinic_id'=>1,'department_id'=>null,'job_title'=>'Clinic Manager',
            'work_start_time'=>'08:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-11-01','status'=>'active',
            'short_biography'=>'Clinic 1 General Manager','created_at'=>now(),'updated_at'=>now()
        ],

        //  محاسب
        [
            'user_id'=>13,'clinic_id'=>1,'department_id'=>null,'job_title'=>'Accountant',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-08-01','status'=>'active',
            'short_biography'=>'Clinic 1 Accountant','created_at'=>now(),'updated_at'=>now()
        ],

        // اثنين ممرضين
        [
            'user_id'=>26,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Nurse',
            'work_start_time'=>'08:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-09-01','status'=>'active',
            'short_biography'=>'Nurse 1','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>27,'clinic_id'=>1,'department_id'=>2,'job_title'=>'Nurse',
            'work_start_time'=>'08:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-04-01','status'=>'active',
            'short_biography'=>'Nurse 2','created_at'=>now(),'updated_at'=>now()
        ],

        // مدراء أقسام
        [
            'user_id'=>5,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Dept 1 Manager','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>6,'clinic_id'=>1,'department_id'=>2,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-02-01','status'=>'active',
            'short_biography'=>'Dept 2 Manager','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>7,'clinic_id'=>1,'department_id'=>7,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-03-01','status'=>'active',
            'short_biography'=>'Dept 7 Manager','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>8,'clinic_id'=>1,'department_id'=>8,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-04-01','status'=>'active',
            'short_biography'=>'Dept 8 Manager','created_at'=>now(),'updated_at'=>now()
        ],

        // استقبال لكل قسم
        [
            'user_id'=>16,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Receptionist',
            'work_start_time'=>'08:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Reception Dept 1','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>17,'clinic_id'=>1,'department_id'=>2,'job_title'=>'Receptionist',
            'work_start_time'=>'08:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Reception Dept 2','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>18,'clinic_id'=>1,'department_id'=>7,'job_title'=>'Receptionist',
            'work_start_time'=>'08:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Reception Dept 7','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>19,'clinic_id'=>1,'department_id'=>8,'job_title'=>'Receptionist',
            'work_start_time'=>'08:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Reception Dept 8','created_at'=>now(),'updated_at'=>now()
        ],

        //  عشرة دكاترة (ضمن وقت العيادة)
        ['user_id'=>31,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-11-01','status'=>'active','short_biography'=>'Doctor 1','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>32,'clinic_id'=>1,'department_id'=>2,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-11-01','status'=>'active','short_biography'=>'Doctor 2','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>33,'clinic_id'=>1,'department_id'=>7,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-12-01','status'=>'active','short_biography'=>'Doctor 3','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>34,'clinic_id'=>1,'department_id'=>8,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-07-01','status'=>'active','short_biography'=>'Doctor 4','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>35,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-08-01','status'=>'active','short_biography'=>'Doctor 5','created_at'=>now(),'updated_at'=>now()],

        ['user_id'=>36,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-02-01','status'=>'active','short_biography'=>'Doctor 6','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>37,'clinic_id'=>1,'department_id'=>2,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 7','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>38,'clinic_id'=>1,'department_id'=>7,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-03','status'=>'active','short_biography'=>'Doctor 8','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>39,'clinic_id'=>1,'department_id'=>8,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 9','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>40,'clinic_id'=>1,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_A_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 10','created_at'=>now(),'updated_at'=>now()],






        // ====================================================
        // CLINIC B  (09:00 → 21:00)
        // Departments: 3, 5, 6, 13
        // ====================================================


        //  مدير العيادة
        [
            'user_id'=>3,'clinic_id'=>2,'department_id'=>null,'job_title'=>'Clinic Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Clinic 2 Manager','created_at'=>now(),'updated_at'=>now()
        ],


        // مدراء أقسام
        [
            'user_id'=>9,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Dept 1 Manager','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>10,'clinic_id'=>2,'department_id'=>5,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-02-01','status'=>'active',
            'short_biography'=>'Dept 2 Manager','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>11,'clinic_id'=>2,'department_id'=>6,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-07-01','status'=>'active',
            'short_biography'=>'Dept 7 Manager','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>12,'clinic_id'=>2,'department_id'=>13,'job_title'=>'Department Manager',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-06-01','status'=>'active',
            'short_biography'=>'Dept 8 Manager','created_at'=>now(),'updated_at'=>now()
        ],


        //  محاسب
        [
            'user_id'=>14,'clinic_id'=>2,'department_id'=>null,'job_title'=>'Accountant',
            'work_start_time'=>'09:00:00','work_end_time'=>'17:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-03-01','status'=>'active',
            'short_biography'=>'Clinic 2 Accountant','created_at'=>now(),'updated_at'=>now()
        ],

        // اثنين ممرضين
        [
            'user_id'=>28,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Nurse',
            'work_start_time'=>'09:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-11-01','status'=>'active',
            'short_biography'=>'Nurse 1','created_at'=>now(),'updated_at'=>now()
        ],
        [
            'user_id'=>29,'clinic_id'=>2,'department_id'=>5,'job_title'=>'Nurse',
            'work_start_time'=>'09:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-06-01','status'=>'active',
            'short_biography'=>'Nurse 2','created_at'=>now(),'updated_at'=>now()
        ],

        // موظف استقبال
        [
            'user_id'=>20,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Receptionist',
            'work_start_time'=>'09:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-05-01','status'=>'active',
            'short_biography'=>'Reception Dept 3','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>21,'clinic_id'=>2,'department_id'=>5,'job_title'=>'Receptionist',
            'work_start_time'=>'09:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-12-01','status'=>'active',
            'short_biography'=>'Reception Dept 5','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>22,'clinic_id'=>2,'department_id'=>6,'job_title'=>'Receptionist',
            'work_start_time'=>'09:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-12-01','status'=>'active',
            'short_biography'=>'Reception Dept 6','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>23,'clinic_id'=>2,'department_id'=>13,'job_title'=>'Receptionist',
            'work_start_time'=>'09:00:00','work_end_time'=>'20:00:00',
            'working_days'=>$Clinic_B_Days,'hire_date'=>'2025-02-01','status'=>'active',
            'short_biography'=>'Reception Dept 13','created_at'=>now(),'updated_at'=>now()
        ],



        //  عشرة دكاترة (ضمن وقت العيادة)
        ['user_id'=>41,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-12-01','status'=>'active','short_biography'=>'Doctor 1','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>42,'clinic_id'=>2,'department_id'=>5,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-12-01','status'=>'active','short_biography'=>'Doctor 2','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>43,'clinic_id'=>2,'department_id'=>6,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-10-01','status'=>'active','short_biography'=>'Doctor 3','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>44,'clinic_id'=>2,'department_id'=>13,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-06-01','status'=>'active','short_biography'=>'Doctor 4','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>45,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-09-01','status'=>'active','short_biography'=>'Doctor 5','created_at'=>now(),'updated_at'=>now()],

        ['user_id'=>46,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-08-01','status'=>'active','short_biography'=>'Doctor 6','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>47,'clinic_id'=>2,'department_id'=>5,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 7','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>48,'clinic_id'=>2,'department_id'=>6,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 8','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>49,'clinic_id'=>2,'department_id'=>13,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 9','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>50,'clinic_id'=>2,'department_id'=>3,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'18:00:00','working_days'=>$Clinic_B_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 10','created_at'=>now(),'updated_at'=>now()],






        // ====================================================
        // CLINIC 3  (10:00 → 16:00)
        // Departments: 1, 15
        // ====================================================

        [
            'user_id'=>4,'clinic_id'=>3,'department_id'=>null,'job_title'=>'Clinic Manager',
            'work_start_time'=>'10:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active',
            'short_biography'=>'Clinic 3 Manager','created_at'=>now(),'updated_at'=>now()
        ],

        //  محاسب
        [
            'user_id'=>15,'clinic_id'=>3,'department_id'=>null,'job_title'=>'Accountant',
            'work_start_time'=>'10:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_C_Days,'hire_date'=>'2025-10-01','status'=>'active',
            'short_biography'=>'Clinic 3 Accountant','created_at'=>now(),'updated_at'=>now()
        ],

        // موظفين استقبال
        [
            'user_id'=>24,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Receptionist',
            'work_start_time'=>'10:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_C_Days,'hire_date'=>'2025-02-01','status'=>'active',
            'short_biography'=>'Reception Dept 1','created_at'=>now(),'updated_at'=>now()
        ],

        [
            'user_id'=>25,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Receptionist',
            'work_start_time'=>'10:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_C_Days,'hire_date'=>'2025-02-01','status'=>'active',
            'short_biography'=>'Reception Dept 1','created_at'=>now(),'updated_at'=>now()
        ],


        //  عشرة دكاترة (ضمن وقت العيادة)
        ['user_id'=>51,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-11-01','status'=>'active','short_biography'=>'Doctor 1','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>52,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-12-01','status'=>'active','short_biography'=>'Doctor 2','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>53,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 3','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>54,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 4','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>55,'clinic_id'=>3,'department_id'=>1,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 5','created_at'=>now(),'updated_at'=>now()],

        ['user_id'=>56,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-10-01','status'=>'active','short_biography'=>'Doctor 6','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>57,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-02-01','status'=>'active','short_biography'=>'Doctor 7','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>58,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 8','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>59,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-01-01','status'=>'active','short_biography'=>'Doctor 9','created_at'=>now(),'updated_at'=>now()],
        ['user_id'=>60,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Doctor','work_start_time'=>'10:00:00','work_end_time'=>'15:00:00','working_days'=>$Clinic_C_Days,'hire_date'=>'2025-09-01','status'=>'active','short_biography'=>'Doctor 10','created_at'=>now(),'updated_at'=>now()],


        // ممرض
        [
            'user_id'=>30,'clinic_id'=>3,'department_id'=>15,'job_title'=>'Nurse',
            'work_start_time'=>'10:00:00','work_end_time'=>'16:00:00',
            'working_days'=>$Clinic_C_Days,'hire_date'=>'2025-09-01','status'=>'active',
            'short_biography'=>'Nurse 1','created_at'=>now(),'updated_at'=>now()
        ],

        ]);
    }
}
