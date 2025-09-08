<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInvoice extends Model{

    protected $fillable = [
        'patient_id',
        'clinic_id',
        'appointment_id',
        'total_amount',
        'discount',
        'final_amount',
        'status',
        'notes',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }


    public function items(){
        return $this->hasMany(PatientInvoiceItem::class, 'invoice_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'invoice_id');
    }
}
