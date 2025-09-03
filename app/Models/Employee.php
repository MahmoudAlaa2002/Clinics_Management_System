<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{
    protected $fillable = [
        'user_id',
        'clinic_id',
        'job_title_id',
        'work_start_time',
        'work_end_time',
        'working_days',
        'hire_date',
        'status',
        'short_biography',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function doctor(){
        return $this->hasOne(Doctor::class);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }

    public function job_title(){
        return $this->belongsTo(JobTitle::class);
    }
}
