<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model{

    protected $fillable = [
        'name',
        'location',
        'email',
        'phone',
        'opening_time',
        'closing_time',
        'working_days',
        'description',
        'status',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public function departments(){
        return $this->belongsToMany(Department::class, 'clinic_departments'); // اسم الجدول الوسيط
    }

    public function employees(){
        return $this->hasMany(Employee::class, 'clinic_id');
    }

}
