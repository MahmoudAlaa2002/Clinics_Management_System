<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model{

    protected $fillable = [
        'appointment_id',
        'nurse_id',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'oxygen_saturation',
        'blood_sugar',
        'notes',
    ];


    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function nurse(){
        return $this->belongsTo(Employee::class, 'nurse_id');
    }
}
