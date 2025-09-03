<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model{

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


    public function departments(){
        return $this->belongsToMany(Department::class, 'clinic_department'); // اسم الجدول الوسيط
    }

    public function clinicDepartments() {
        return $this->hasMany(ClinicDepartment::class);
    }


    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,
            Employee::class,
            'clinic_id',       // مفتاح خارجي في employees يشير إلى العيادة
            'employee_id',     // مفتاح خارجي في doctors يشير إلى الموظف
            'id',              // المفتاح الأساسي في clinics
            'id'               // المفتاح الأساسي في employees
        );
    }


    public function patients(){
        return $this->belongsToMany(Patient::class, 'clinic_patients');
    }

    public function medicineStocks(){
        return $this->hasMany(MedicineStock::class);
    }
}
