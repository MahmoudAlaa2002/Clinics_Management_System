<?php

namespace App\Events;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AppointmentAccepted {
    use Dispatchable, SerializesModels;

    public Appointment $appointment;
    public User $actor;

    public function __construct(Appointment $appointment, User $actor) {
        $this->appointment = $appointment;
        $this->actor = $actor;
    }
}


