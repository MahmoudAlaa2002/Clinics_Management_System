<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeJobTitle extends Model{

    protected $fillable = [
        'employee_id',
        'job_title_id',
        'hire_date',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function jobTitles(){
        return $this->belongsTo(JobTitle::class);
    }
}
