<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{

    protected $fillable = [
        'name',
        'specialty_id',
        'image',
        'work_start_time',
        'work_end_time',
        'working_days',
        'is_in_charge',
        'clinic_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
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
