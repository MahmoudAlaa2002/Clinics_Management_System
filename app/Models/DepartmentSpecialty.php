<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentSpecialty extends Model{

    protected $fillable = [
        'department_id',
        'specialty_id',
    ];
}
