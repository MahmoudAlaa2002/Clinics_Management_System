<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model{

    protected $fillable = [
        'name',
    ];

    public function departments() {
        return $this->belongsToMany(Department::class, 'department_specialty');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
}
