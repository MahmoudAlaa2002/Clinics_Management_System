<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_type',
        'emergency_contact',
        'allergies',
        'chronic_diseases',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function doctors(){
        return $this->hasManyThrough(
            Doctor::class,
            Appointment::class,
            'patient_id',
            'id',
            'id',
            'doctor_id'
        );
    }

    public function medicalRecords(){
        return $this->hasMany(MedicalRecord::class);
    }

    public function clinicPatients(){
        return $this->hasMany(ClinicPatient::class, 'patient_id');
    }

    public function clinics() {
        return $this->belongsToMany(Clinic::class, 'clinic_patients');
    }


}
