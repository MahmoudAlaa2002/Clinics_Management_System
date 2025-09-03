<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{

    protected $fillable = [
        'employee_id',
        'clinic_department_id',
        'qualification',
        'experience_years',
    ];


    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function clinicDepartment(){
        return $this->belongsTo(ClinicDepartment::class, 'clinic_department_id');
    }

    public function clinic(){
        return $this->hasOneThrough(
            Clinic::class,
            ClinicDepartment::class,
            'id',
            'id',
            'clinic_department_id',
            'clinic_id'
        );
    }

    public function department(){
        return $this->hasOneThrough(
            Department::class,
            ClinicDepartment::class,
            'id',            // Foreign key on clinic_departments table
            'id',            // Foreign key on departments table
            'clinic_department_id', // Local key on doctors table
            'department_id'  // Local key on clinic_departments table
        );
    }














    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function patients(){
        return $this->hasManyThrough(
            Patient::class,
            Appointment::class,
            'doctor_id',
            'id',
            'id',
            'patient_id'
        );
    }


    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }

}
