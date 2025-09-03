<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentPatient extends Model{

    protected $fillable = [
        'patient_id',
        'department_id',
    ];
}
