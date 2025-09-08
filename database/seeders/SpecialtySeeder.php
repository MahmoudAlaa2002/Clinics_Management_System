<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'General Internal Medicine',      // طب الباطنة العامة
            'Endocrinology and Diabetes',     // الغدد الصماء والسكري
            'Hematology',                     // أمراض الدم
            'Gastroenterology',               // الجهاز الهضمي
            'Rheumatology',                   // الروماتيزم والمفاصل
            'Nephrology',                     // الكلى
            'Urology',                        // المسالك البولية
            'Pulmonology / Respiratory Medicine', // الأمراض الصدرية والتنفسية
            'General Surgery',                // جراحة عامة
            'Vascular Surgery',               // جراحة الأوعية الدموية
            'Orthopedic Surgery',             // جراحة العظام
            'Spinal Surgery',                 // جراحة العمود الفقري
            'Joint Replacement Surgery',      // جراحة المفاصل الصناعية
            'Hand Surgery',                   // جراحة اليد
            'Neurosurgery',                   // جراحة المخ والأعصاب
            'Cardiothoracic Surgery',         // جراحة القلب والصدر
            'Retinal Surgery',                // جراحة الشبكية
            'Cataract and Glaucoma Surgery',  // جراحة المياه البيضاء والزرقاء
            'General ENT',                    // الأنف والأذن والحنجرة
            'Nasal and Sinus Surgery',        // جراحة الأنف والجيوب
            'Ear and Hearing Surgery',        // جراحة الأذن والسمع
            'Laryngeal Surgery',              // جراحة الحنجرة
            'Oral and Maxillofacial Surgery', // جراحة الفم والفكين
            'Orthodontics',                   // تقويم الأسنان
            'Pediatric Dentistry',            // أسنان الأطفال
            'Dermatology',                    // الأمراض الجلدية
            'General Pediatrics',             // طب الأطفال
            'Neonatology',                    // حديثي الولادة
            'Pediatric Neurology',            // أعصاب الأطفال
            'Gynecology',                     // طب النساء
            'Obstetrics',                     // التوليد
            'Infertility and IVF',            // العقم وأطفال الأنابيب
            'Neurology',                      // طب الأعصاب
            'Kidney Transplant',              // زراعة الكلى
            'Medical Oncology',               // طب الأورام
            'Radiation Oncology',             // علاج إشعاعي
            'Pediatric Oncology',             // أورام الأطفال
            'General Psychiatry',
            'Addiction Treatment',
            'Child and Adolescent Psychiatry',
            'General Emergency Medicine',
            'Trauma and Accidents',
            'Critical Care',
            'Interventional Cardiology',
            'Electrophysiology',
            'Non-Invasive Cardiology',
            'General Family Medicine',
        ];

        foreach ($specialties as $specialty) {
            DB::table('specialties')->insert([
                'name' => $specialty,
            ]);
        }
    }
}
