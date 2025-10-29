<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model{

    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'patient_id',
        'diagnosis',
        'treatment',
        'record_date',
        'prescriptions',
        'attachmentss',
        'notes',
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }


    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }


    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
