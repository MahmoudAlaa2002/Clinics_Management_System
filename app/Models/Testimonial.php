<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model{
    
    protected $fillable = [
        'patient_id',
        'content',
        'rating',
        'is_approved',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
