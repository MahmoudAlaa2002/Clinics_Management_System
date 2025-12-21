<?php

namespace App\Listeners;

use App\Events\NurseTaskAssigned;
use App\Models\User;
use App\Notifications\NurseTaskAssignedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnNurseTaskAssigned {

    public function handle(NurseTaskAssigned $event): void {

        $task = $event->nurseTask;

        $nurse = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($task) {
                $q->where('id', $task->nurse_id)
                  ->where('job_title', 'Nurse');
            })->first();

        Notification::send($nurse,new NurseTaskAssignedNotification($task));
    }
}
