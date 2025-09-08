<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;

class DepartmentSpecialtySeeder extends Seeder
{
    public function run(): void
    {
        // Clear old data
        DB::table('department_specialty')->truncate();

        // Departments with their related specialties
        $mapping = [
            'General Medicine' => [
                'General Internal Medicine',
                'Endocrinology and Diabetes',
                'Gastroenterology',
                'Nephrology',
                'Pulmonology / Respiratory Medicine',
                'Hematology',
                'Rheumatology',
            ],
            'General Surgery' => [
                'General Surgery',
                'Vascular Surgery',
                'Cardiothoracic Surgery',
            ],
            'Orthopedics' => [
                'Orthopedic Surgery',
                'Spinal Surgery',
                'Joint Replacement Surgery',
                'Hand Surgery',
            ],
            'Pediatrics' => [
                'General Pediatrics',
                'Neonatology',
                'Pediatric Neurology',
            ],
            'Obstetrics and Gynecology' => [
                'Gynecology',
                'Obstetrics',
                'Infertility and IVF',
            ],
            'Cardiology' => [
                'Interventional Cardiology',      // قسطرة القلب
                'Electrophysiology',              // كهرباء القلب واضطراب النظم
                'Non-Invasive Cardiology',        // التشخيص غير التدخلي
            ],
            'Ophthalmology' => [
                'Retinal Surgery',
                'Cataract and Glaucoma Surgery',
            ],
            'ENT (Otolaryngology)' => [
                'General ENT',
                'Nasal and Sinus Surgery',
                'Ear and Hearing Surgery',
                'Laryngeal Surgery',
            ],
            'Dentistry' => [
                'Oral and Maxillofacial Surgery',
                'Orthodontics',
                'Pediatric Dentistry',
            ],
            'Dermatology' => [
                'Dermatology',
            ],
            'Neurology' => [
                'Neurology',
                'Pediatric Neurology',
                'Neurosurgery',
            ],
            'Nephrology and Urology' => [
                'Nephrology',
                'Urology',
                'Kidney Transplant',
            ],
            'Oncology' => [
                'Medical Oncology',
                'Radiation Oncology',
                'Pediatric Oncology',
            ],
            'Psychiatry' => [
                'General Psychiatry',
                'Addiction Treatment',
                'Child and Adolescent Psychiatry',
            ],
            'Emergency Medicine' => [
                'General Emergency Medicine',
                'Trauma and Accidents',
                'Critical Care',
            ],
            'Family Medicine' => [
                'General Family Medicine',
            ],
        ];

        foreach ($mapping as $departmentName => $specialties) {
            $department = Department::where('name', $departmentName)->first();

            if ($department) {
                foreach ($specialties as $specialtyName) {
                    $specialty = Specialty::where('name', $specialtyName)->first();
                    if ($specialty) {
                        $department->specialties()->syncWithoutDetaching([$specialty->id]);
                    }
                }
            }
        }
    }
}
