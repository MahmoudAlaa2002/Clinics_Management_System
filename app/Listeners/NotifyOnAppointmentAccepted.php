<?php

namespace App\Listeners;

use App\Events\AppointmentAccepted;
use App\Models\User;
use App\Notifications\AppointmentAcceptedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentAccepted {
    public function handle(AppointmentAccepted $event): void {
        $appointment = $event->appointment;

        if ($appointment->booked_by !== 'patient') {
            return;
        }

        $patient = User::whereHas('patient', function ($q) use ($appointment) {
            $q->where('id', $appointment->patient_id);
        })->first();

        if (!$patient) {
            return;
        }

        Notification::send($patient,new AppointmentAcceptedNotification($appointment));
    }
}
