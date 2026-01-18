<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentHold extends Model {

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'clinic_department_id',
        'date',
        'time',
        'amount',
        'status',
        'expires_at',
    ];

    public function bankPayment() {
        return $this->hasOne(BankPayment::class, 'hold_id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function clinicDepartment() {
        return $this->belongsTo(ClinicDepartment::class);
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

}
