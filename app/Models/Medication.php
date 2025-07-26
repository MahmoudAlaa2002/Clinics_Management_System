<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model{

    protected $fillable = [
        'name',
        'dosage_form_id',
        'strength',
        'image',
        'description',
        'purchase_price',
        'selling_price',
    ];


    public function dosageForm(){
        return $this->belongsTo(DosageForm::class);
    }

    public function medicineStocks(){
        return $this->hasMany(MedicineStock::class);
    }

    public function prescriptionItems(){
        return $this->hasMany(PrescriptionItem::class);
    }
}
