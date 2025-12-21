<?php

namespace App\Listeners;

use App\Events\AppointmentCancelled;
use App\Models\User;
use App\Notifications\AppointmentCancelledNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentCancelled {

    public function handle(AppointmentCancelled $event): void {
        $appointment = $event->appointment;
        $actor       = $event->actor;

        // 🔐 أمان: لا يوجد actor
        if (!$actor) {
            return;
        }

        /**
         * تحديد من قام بالإلغاء
         * Doctor | Patient | Receptionist
         */
        $actorRole = match ($actor->role) {
            'doctor'  => 'doctor',
            'patient' => 'patient',
            'employee' => optional($actor->employee)->job_title === 'Receptionist' ? 'receptionist' : null,
            default => null,
        };


        $recipients = collect();

        /**
         * المستلمين (حسب منطقك)
         */

        $doctor = User::whereHas('employee.doctor', fn ($q) =>
            $q->where('id', $appointment->doctor_id)
        )->get();

        $patient = User::whereHas('patient', fn ($q) =>
            $q->where('id', $appointment->patient_id)
        )->get();

        $receptionist = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($appointment) {
                $q->where('clinic_id', $appointment->clinic->id)
                  ->where('department_id', $appointment->department->id)
                  ->where('job_title', 'Receptionist');
            })->get();

        /**
         * قواعد الإرسال حسب من ألغى
         */
        if ($actorRole === 'doctor') {
            $recipients = $recipients
            ->merge($patient)
            ->merge($receptionist);
        }

        if ($actorRole === 'patient') {
            $recipients = $recipients
            ->merge($doctor)
            ->merge($receptionist);
        }

        if ($actorRole === 'receptionist') {
            $recipients = $recipients->merge($doctor)->merge($patient);
        }

        // إزالة التكرار + إزالة الشخص اللي لغى
        $recipients = $recipients->unique('id')->reject(fn ($u) => $u->id === $actor->id)->values();

        Notification::send($recipients,new AppointmentCancelledNotification($appointment, $actorRole)
        );
    }
}
