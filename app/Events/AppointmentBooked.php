<?php

namespace App\Events;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked {

    use Dispatchable, SerializesModels;

    public Appointment $appointment;
    public ?User $actor;   // الشخص الذي قام بالحجز

    public function __construct(Appointment $appointment, ?User $actor = null) {
        $this->appointment = $appointment;
        $this->actor = $actor;
    }
}
