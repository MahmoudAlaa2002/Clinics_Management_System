<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model{

    protected $fillable = [
        'name',
        'location',
        'doctor_in_charge',
        'clinic_phone',
        'opening_time',
        'closing_time',
        'working_days',
        'specialties',
        'description',
        'status',
    ];


    public function specialties(){
        return $this->belongsToMany(Specialty::class, 'clinic_specialties'); // اسم الجدول الوسيط
    }


    public function doctors(){
        return $this->hasMany(Doctor::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_in_charge');
    }


    public function patients(){
        return $this->belongsToMany(Patient::class, 'clinic_patients');
    }

    public function medicineStocks(){
        return $this->hasMany(MedicineStock::class);
    }
}
