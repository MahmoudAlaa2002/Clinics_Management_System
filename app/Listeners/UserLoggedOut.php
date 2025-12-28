<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UserLoggedOut
{
    public function handle(Logout $event): void
    {
        $user = $event->user;

        if (! $user) return;

        $user->update([
            'is_online' => false,
            'last_seen' => now(),
        ]);

        broadcast(new \App\Events\UserStatusChanged($user));
    }
}
