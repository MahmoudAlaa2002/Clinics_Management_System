<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'General Medicine'],            // قسم الباطنة
            ['name' => 'General Surgery'],             // قسم الجراحة
            ['name' => 'Orthopedics'],                 // قسم العظام
            ['name' => 'Pediatrics'],                  // قسم الأطفال
            ['name' => 'Obstetrics and Gynecology'],   // قسم النساء والتوليد
            ['name' => 'Ophthalmology'],               // قسم العيون
            ['name' => 'ENT (Otolaryngology)'],        // قسم الأنف والأذن والحنجرة
            ['name' => 'Dentistry'],                   // قسم الأسنان
            ['name' => 'Dermatology'],                 // قسم الجلدية
            ['name' => 'Cardiology'],                  // قسم القلب
            ['name' => 'Nephrology and Urology'],      // قسم الكلى والمسالك البولية
            ['name' => 'Neurology'],                   // قسم المخ والأعصاب
            ['name' => 'Oncology'],                    // قسم الأورام
            ['name' => 'Psychiatry'],                  // قسم الطب النفسي
            ['name' => 'Family Medicine'],             // قسم طب الأسرة والمجتمع
            ['name' => 'Emergency Medicine'],          // قسم الطوارئ
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['name' => $department['name']],
                ['description' => 'No description is available for this department yet.']
            );
        }
    }
}
