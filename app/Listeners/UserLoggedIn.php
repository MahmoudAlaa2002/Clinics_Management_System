<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UserLoggedIn
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        $user->update([
            'is_online'  => true,
            'last_seen'  => now(),
        ]);

        broadcast(new \App\Events\UserStatusChanged($user));
    }
}
