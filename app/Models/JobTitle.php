<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model{

    protected $fillable = [
        'name',
        'need_department',
        'need_doctor'
    ];


    public function employees(){
        return $this->belongsToMany(Employee::class, 'employee_job_titles');
    }
}
