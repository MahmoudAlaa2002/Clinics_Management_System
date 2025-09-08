<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model{

    protected $fillable = [
        'name',
        'description',
    ];

    public function clinics(){
        return $this->belongsToMany(Clinic::class, 'clinic_department');
    }

    public function specialties() {
        return $this->belongsToMany(Specialty::class, 'department_specialty');
    }

    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,       // الموديل النهائي
            Employee::class,     // الموديل الوسيط
            'department_id',     // المفتاح في جدول employees
            'employee_id',       // المفتاح في جدول doctors
            'id',                // المفتاح في جدول departments
            'id'                 // المفتاح في جدول employees
        );
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'department_patients');
    }
}
