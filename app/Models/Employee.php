<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_id',
        'department_id',
        'job_title',
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


    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }


    public function department(){
        return $this->belongsTo(Department::class);
    }


    public function doctor(){
        return $this->hasOne(Doctor::class, 'employee_id');
    }




    // تجعل الوقت بالصيغة هادي 08:00 , 19:00
    public function getWorkStartTimeAttribute($value){
        return $value ? \Carbon\Carbon::parse($value)->format('H:i') : null;
    }

    public function getWorkEndTimeAttribute($value){
        return $value ? \Carbon\Carbon::parse($value)->format('H:i') : null;
    }

}
