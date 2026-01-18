<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalAccount extends Model {
    
    protected $fillable = [
        'clinic_id',
        'client_id',
        'client_secret',
        'is_live',
        'currency',
    ];
}
