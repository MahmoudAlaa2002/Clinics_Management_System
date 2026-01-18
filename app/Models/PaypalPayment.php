<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalPayment extends Model {

    protected $fillable = [
        'invoice_id',
        'patient_id',
        'clinic_id',
        'paypal_order_id',
        'paypal_capture_id',
        'payer_email',
        'amount',
        'currency',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
