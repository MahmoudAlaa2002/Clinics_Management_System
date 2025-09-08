<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'clinic_department_id',
        'date',
        'time',
        'status',
        'notes',
        'consultation_fee',
    ];

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
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
