<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialtyPatient extends Model{

    protected $fillable = [
        'patient_id',
        'specialty_id',
    ];
}
