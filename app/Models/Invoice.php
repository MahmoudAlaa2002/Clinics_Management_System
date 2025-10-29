<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model{

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'total_amount',
        'payment_status',
        'invoice_date',
        'due_date',
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
