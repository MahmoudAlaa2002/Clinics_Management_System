<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model{

    protected $fillable = [
        'clinic_id',
        'medication_id',
        'quantity',
        'batch_number',
        'description',
        'remaining_quantity',
    ];


    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function medication(){
        return $this->belongsTo(Medication::class);
    }
}
