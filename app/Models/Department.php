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

    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,
            ClinicDepartment::class,
            'department_id', // المفتاح الخارجي في جدول clinic_department الذي يشير إلى هذا القسم
            'clinic_department_id', // المفتاح في جدول doctors الذي يشير إلى clinic_department
            'id', // المفتاح الأساسي في جدول departments
            'id' // المفتاح الأساسي في جدول clinic_department
        );
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'department_patients');
    }
}
