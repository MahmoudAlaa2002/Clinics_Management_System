<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model{
    protected $fillable = [
        'medication_id',
        'quantity',
        'batch_number',
        'manufacture_date',
        'expiry_date',
        'clinic_id',
        'description',
    ];


    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function medication(){
        return $this->belongsTo(Medication::class);
    }
}
