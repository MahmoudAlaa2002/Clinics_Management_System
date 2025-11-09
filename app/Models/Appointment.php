<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model{

    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'clinic_department_id',
        'date',
        'time',
        'status',
        'notes',
        'consultation_fee',
    ];

    // العلاقة المباشرة مع جدول clinic_departments
    public function clinicDepartment(){
        return $this->belongsTo(ClinicDepartment::class);
    }

    // الوصول للعيادة من خلال جدول clinic_departments
    public function clinic(){
        return $this->hasOneThrough(
            Clinic::class,
            ClinicDepartment::class,
            'id',              // المفتاح الأساسي في clinic_departments
            'id',              // المفتاح الأساسي في clinics
            'clinic_department_id', // المفتاح الأجنبي في appointments
            'clinic_id'        // المفتاح الأجنبي في clinic_departments
        );
    }

    // الوصول للقسم من خلال جدول clinic_departments
    public function department(){
        return $this->hasOneThrough(
            Department::class,
            ClinicDepartment::class,
            'id',                 // المفتاح الأساسي في clinic_departments
            'id',                 // المفتاح الأساسي في departments
            'clinic_department_id', // المفتاح الأجنبي في appointments
            'department_id'       // المفتاح الأجنبي في clinic_departments
        );
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function medicalRecord(){
        return $this->hasOne(MedicalRecord::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }

}
