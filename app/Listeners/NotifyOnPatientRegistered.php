<?php

namespace App\Listeners;

use App\Events\PatientRegistered;
use App\Models\User;
use App\Notifications\PatientRegisteredNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnPatientRegistered {

    public function handle(PatientRegistered $event): void {
        $patient = $event->patient;
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins,new PatientRegisteredNotification($patient));
    }
}
