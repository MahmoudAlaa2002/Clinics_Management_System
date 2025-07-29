<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{
    protected $fillable = [
        'name',
        'job_title_id',
        'status',
        'user_id',
        'clinic_id',
        'specialty_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function job_title(){
        return $this->belongsTo(JobTitle::class);
    }
}
