<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // endpoint: /broadcasting/auth
        Broadcast::routes(['middleware' => ['web', 'auth']]);


        // load channels file
        require base_path('routes/channels.php');
    }
}
