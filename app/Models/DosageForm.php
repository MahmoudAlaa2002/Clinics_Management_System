<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosageForm extends Model
{
    protected $fillable = [
        'name',
    ];


    public function medications(){
        return $this->hasMany(Medication::class);

    }
}
