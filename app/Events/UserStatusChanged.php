<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserStatusChanged implements ShouldBroadcast {
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function broadcastOn() {
        return new Channel('online-users');
    }


    public function broadcastAs(): string {
        return 'user.status';
    }

    public function broadcastWith(): array {
        return [
            'id'        => $this->user->id,
            'is_online' => (bool) $this->user->is_online,
            'last_seen' => optional($this->user->last_seen)->toDateTimeString(),
        ];
    }

}
