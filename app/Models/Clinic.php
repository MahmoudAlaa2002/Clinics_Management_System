<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model{

    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'email',
        'phone',
        'opening_time',
        'closing_time',
        'working_days',
        'description',
        'status',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public function departments(){
        return $this->belongsToMany(Department::class, 'clinic_departments')->withTimestamps(); // اسم الجدول الوسيط
    }

    public function employees(){
        return $this->hasMany(Employee::class, 'clinic_id');
    }

    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,     // الجدول النهائي
            Employee::class,   // الجدول الوسيط
            'clinic_id',       // FK في employees
            'employee_id',     // FK في doctors
            'id',              // PK في clinics
            'id'               // PK في employees
        );
    }


    // علاقة مباشرة العيادة مع المواعيد
    public function appointments(){
        return $this->hasManyThrough(
            Appointment::class,
            ClinicDepartment::class,
            'clinic_id',            // foreign key in clinic_departments
            'clinic_department_id', // foreign key in appointments
            'id',                   // local key in clinics
            'id'                    // local key in clinic_departments
        );
    }


    public function clinicDepartments(){
        return $this->hasMany(ClinicDepartment::class, 'clinic_id');
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'clinic_patients');
    }


}
