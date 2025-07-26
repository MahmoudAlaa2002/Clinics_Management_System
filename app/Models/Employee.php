<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{
    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'job_title_id',
        'short_biography',
        'status',
        'user_id',
        'clinic_id',
        'specialty_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
