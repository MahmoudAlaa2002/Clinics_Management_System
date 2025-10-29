<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{

    protected $fillable = [
        'employee_id',
        'speciality',
        'qualification',
        'consultation_fee',
        'rating',
    ];


    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
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

}
