<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model{

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function clinics(){
        return $this->belongsToMany(Clinic::class, 'clinic_departments');
    }


    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,             // الموديل النهائي
            Employee::class,           // الجدول الوسيط
            'department_id',    // المفتاح الأجنبي في employees
            'employee_id',             // المفتاح الأجنبي في doctors
            'id',                      // المفتاح الأساسي في departments
            'id'                       // المفتاح الأساسي في employees
        );
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'department_patients');
    }
}
