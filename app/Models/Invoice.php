<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model{

    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'total_amount',
        'payment_status',
        'invoice_date',
        'due_date',
        'notes',
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
