<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model{

    protected $fillable = [
        'user_id',
        'action',
        'target_table',
        'old_data',
        'new_data',
        'ip_address',
        'details',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
