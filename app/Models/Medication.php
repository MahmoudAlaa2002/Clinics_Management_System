<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model{

    protected $fillable = [
        'name',
        'form',
        'category',
        'selling_price',
        'expiration_date',
        'description',
    ];


    public function medicineStocks(){
        return $this->hasMany(MedicineStock::class);
    }

    public function prescriptionItems(){
        return $this->hasMany(PrescriptionItem::class);
    }
}
