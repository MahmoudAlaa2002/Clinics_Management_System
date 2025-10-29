<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicDepartment extends Model{

    public $timestamps = false;

    protected $fillable = [
        'clinic_id',
        'department_id',
    ];

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class, 'department_id');
    }

}
