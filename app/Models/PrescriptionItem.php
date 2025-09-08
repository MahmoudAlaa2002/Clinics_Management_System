<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model{

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'dosage',
        'duration',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function prescription(){
        return $this->belongsTo(Prescription::class);
    }

    public function medications(){
        return $this->belongsTo(Medication::class, 'medicine_id');
    }
}
