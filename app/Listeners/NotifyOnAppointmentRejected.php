<?php

namespace App\Listeners;

use App\Events\AppointmentRejected;
use App\Models\User;
use App\Notifications\AppointmentRejectedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentRejected {

    public function handle(AppointmentRejected $event): void {

        $appointment = $event->appointment;

        $patient = User::whereHas('patient', function ($q) use ($appointment) {
            $q->where('id', $appointment->patient_id);
        })->first();

        if (!$patient) {
            return;
        }

        Notification::send($patient,new AppointmentRejectedNotification($appointment));
    }
}
