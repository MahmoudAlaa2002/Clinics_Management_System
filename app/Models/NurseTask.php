<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseTask extends Model{

    protected $fillable = [
        'appointment_id',
        'task',
        'status',
        'performed_at',
        'notes',
    ];


    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function nurse(){
        return $this->belongsTo(Employee::class, 'nurse_id');
    }

}
