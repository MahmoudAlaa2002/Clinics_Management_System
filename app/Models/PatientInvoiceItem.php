<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInvoiceItem extends Model{
    protected $fillable = [
        'invoice_id',
        'service_name',
        'service_type',
        'amount',
    ];

    public function invoice(){
        return $this->belongsTo(PatientInvoice::class, 'invoice_id');
    }
}
