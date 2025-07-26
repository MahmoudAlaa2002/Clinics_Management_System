<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model{

    protected $fillable = [
        'name',
        'description',
    ];

    public function clinics(){
        return $this->belongsToMany(Clinic::class, 'clinic_specialties');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }

    public function patients(){
        return $this->belongsToMany(Patient::class, 'specialty_patients');
    }
}
