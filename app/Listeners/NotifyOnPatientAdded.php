<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\PatientAdded;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PatientAddedNotification;


class NotifyOnPatientAdded {

    public function handle(PatientAdded $event): void {
        $patient = $event->patient;
        $actor   = $event->actor;   // الشخص الذي أضاف المريض

        $recipients = collect();

        $admins = User::where('role', 'admin')->get();

        $clinicManagers = User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) use ($actor) {
                $q->where('clinic_id', optional($actor->employee)->clinic_id);
            })->get();

        $receptionists = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($actor) {
                $q->where('clinic_id', optional($actor->employee)->clinic_id)
                  ->where('job_title', 'Receptionist');
            })->get();

        /**
         * ========= قواعد الإشعار =========
         */

        // 👑 Admin أضاف المريض → لا إشعار
        if ($actor->role === 'admin') {
            return;
        }

        // 🏥 Clinic Manager أضاف المريض
        if ($actor->role === 'clinic_manager') {
            $recipients = $recipients
                ->merge($admins)
                ->merge($receptionists);
        }

        if ($actor->role === 'employee' && optional($actor->employee)->job_title === 'Receptionist') {
            $recipients = $recipients
                ->merge($admins)
                ->merge($clinicManagers);
        }

        $recipients = $recipients->unique('id')->reject(fn ($user) => $user->id === $actor->id)->values();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients,new PatientAddedNotification($patient, $actor));
    }
}
