<?php

namespace App\Listeners;

use App\Events\AppointmentAccepted;
use App\Models\User;
use App\Notifications\AppointmentAcceptedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentAccepted {
    public function handle(AppointmentAccepted $event): void {

        $appointment = $event->appointment;
        $actor       = $event->actor;


        $patient = $appointment->patient->user;
        if (!$patient) return;

        Notification::send(
            $patient,
            new AppointmentAcceptedNotification($appointment, $actor)
        );
    }
}
