<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'clinic_id',
        'specialty_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }


    public function patient(){
        return $this->belongsTo(Patient::class);
    }


    public function prescriptions(){
        return $this->hasOne(Prescription::class);
    }

}
