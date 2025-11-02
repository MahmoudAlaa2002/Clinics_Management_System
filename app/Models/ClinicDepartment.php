<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicDepartment extends Model{

    use HasFactory;

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
