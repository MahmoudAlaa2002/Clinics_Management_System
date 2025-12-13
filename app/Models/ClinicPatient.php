<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicPatient extends Model{

    protected $fillable = [
        'clinic_id',
        'patient_id',
    ];
}
