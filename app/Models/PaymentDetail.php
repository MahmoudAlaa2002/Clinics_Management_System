<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model{

    protected $fillable = [
        'payment_id',
        'amount_paid',
        'payment_method',
        'payment_date',
        'notes',
    ];


    public function payments(){
        return $this->belongsTo(Payment::class);
    }
}
