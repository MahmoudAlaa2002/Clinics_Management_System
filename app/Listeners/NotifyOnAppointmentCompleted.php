<?php

namespace App\Listeners;

use App\Events\AppointmentCompleted;
use App\Models\User;
use App\Models\VitalSign;
use App\Notifications\AppointmentCompletedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentCompleted {

    public function handle(AppointmentCompleted $event): void {
        $appointment = $event->appointment;
        $recipients  = collect();

        $vitalSign = VitalSign::where('appointment_id', $appointment->id)->first();

        if ($vitalSign && $vitalSign->nurse_id) {

            $nurse = User::where('role', 'employee')
                ->whereHas('employee', function ($q) use ($vitalSign) {
                    $q->where('id', $vitalSign->nurse_id)
                      ->where('job_title', 'Nurse');
                })
                ->first();

            if ($nurse) {
                $recipients->push($nurse);
            }
        }


        $patient = User::whereHas('patient', function ($q) use ($appointment) {
            $q->where('id', $appointment->patient_id);
        })->first();

        if ($patient) {
            $recipients->push($patient);
        }


        $recipients = $recipients->unique('id')->values();

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients,new AppointmentCompletedNotification($appointment));
        }
    }
}
