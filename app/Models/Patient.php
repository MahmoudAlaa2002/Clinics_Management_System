<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model{

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'short_biography',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function clinics(){
        return $this->belongsToMany(Clinic::class, 'clinic_patients');
    }

    public function specialties(){
        return $this->belongsToMany(Specialty::class, 'specialty_patients');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,
            Appointment::class,
            'patient_id',
            'id',
            'id',
            'doctor_id'
        );
    }


    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }

}
