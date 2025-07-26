<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{

    protected $fillable = [
        'invoice_id',
    ];


    public function invoice(){
        return $this->belongsTo(PatientInvoice::class);
    }


    public function paymentDetails(){
        return $this->hasMany(PaymentDetail::class);
    }
}
