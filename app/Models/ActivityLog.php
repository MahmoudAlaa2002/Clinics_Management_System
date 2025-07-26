<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model{

    protected $fillable = [
        'user_id',
        'action_type',
        'module',
        'description',
        'old_data',
        'new_data',
        'ip_address',
    ];
}
