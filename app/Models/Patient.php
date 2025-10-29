<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model{

    protected $fillable = [
        'user_id',
        'blood_type',
        'emergency_contact',
        'allergies',
        'chronic_diseases',
    ];

    public function user(){
        return $this->belongsTo(User::class);
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
}
