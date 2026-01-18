<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPayment extends Model {

    protected $fillable = [
        'hold_id',
        'appointment_id',
        'reference_number',
        'receipt',
        'status',
    ];


    public function hold() {
        return $this->belongsTo(AppointmentHold::class, 'hold_id');
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function patient() {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
