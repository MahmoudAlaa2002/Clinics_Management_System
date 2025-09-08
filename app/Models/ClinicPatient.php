<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicPatient extends Model{

    protected $fillable = [
        'patient_id',
        'clinic_id',
    ];
}
