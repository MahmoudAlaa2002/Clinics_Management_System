<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{

    protected $fillable = [
        'employee_id',
        'qualification',
        'experience_years',
        'specialty_id',
    ];


    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }


    public function specialty(){
        return $this->belongsTo(Specialty::class);
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
