<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;

class MedicalRecordsSeeder extends Seeder{

    public function run(): void{

        MedicalRecord::create([
            'appointment_id' => 2,
            'doctor_id'      => 2,
            'patient_id'     => 2,
            'diagnosis'      => 'General Checkup',
            'treatment'      => 'Lifestyle modification + Antihypertensive medication',
            'record_date'    => '2025-12-01',
            'prescriptions' => 'Amlodipine 5mg once daily',
            'attachments'   => 'ECG Report, Blood Pressure Chart',
            'notes'          => 'Patient advised to reduce salt intake and monitor BP regularly.',
        ]);

        MedicalRecord::create([
            'appointment_id' => 6,
            'doctor_id'      => 6,
            'patient_id'     => 6,
            'diagnosis'      => 'Follow-up Visit',
            'treatment'      => 'Oral hypoglycemic agents + Diet control',
            'record_date'    => '2025-12-03',
            'prescriptions' => 'Metformin 500mg twice daily',
            'attachments'   => 'HbA1c Test, Fasting Blood Sugar Report',
            'notes'          => 'Patient instructed on glucose monitoring and diet plan.',
        ]);

        MedicalRecord::create([
            'appointment_id' => 9,
            'doctor_id'      => 12,
            'patient_id'     => 9,
            'diagnosis'      => 'Chronic Disease Follow-up',
            'treatment'      => 'Symptomatic treatment + Rest',
            'record_date'    => '2025-12-01',
            'prescriptions' => 'Paracetamol 500mg, Vitamin C',
            'attachments'   => 'Chest X-Ray',
            'notes'          => 'Patient advised to increase fluids and rest for 3–5 days.',
        ]);

        MedicalRecord::create([
            'appointment_id' => 12,
            'doctor_id'      => 15,
            'patient_id'     => 12,
            'diagnosis'      => 'Acute Illness Evaluation',
            'treatment'      => 'Proton Pump Inhibitors + Diet adjustment',
            'record_date'    => '2025-12-02',
            'prescriptions' => 'Omeprazole 20mg once daily',
            'attachments'   => 'Endoscopy Report',
            'notes'          => 'Avoid spicy food and NSAIDs.',
        ]);

        MedicalRecord::create([
            'appointment_id' => 17,
            'doctor_id'      => 23,
            'patient_id'     => 17,
            'diagnosis'      => 'Injury / Trauma',
            'treatment'      => 'Iron supplementation + Nutritional therapy',
            'record_date'    => '2025-12-01',
            'prescriptions' => 'Ferrous Sulfate 325mg once daily',
            'attachments'   => 'CBC Report',
            'notes'          => 'Follow-up after one month recommended to reassess hemoglobin level.',
        ]);
    }
}
