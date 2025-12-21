<?php

namespace App\Listeners;

use App\Events\NurseTaskCompleted;
use App\Models\User;
use App\Notifications\NurseTaskCompletedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnNurseTaskCompleted {

    public function handle(NurseTaskCompleted $event): void {
        $task = $event->task;

        $doctor = User::where('role', 'doctor')
            ->whereHas('employee.doctor', function ($q) use ($task) {
                $q->where('id', $task->appointment->doctor_id);
            })->first();

        if (!$doctor) {
            return;
        }

        Notification::send($doctor,new NurseTaskCompletedNotification($task));
    }
}
