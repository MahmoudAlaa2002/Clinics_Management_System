<?php

namespace App\Notifications;

use App\Models\NurseTask;
use Illuminate\Notifications\Notification;

class NurseTaskCompletedNotification extends Notification {
    protected NurseTask $task;

    public function __construct(NurseTask $task) {
        $this->task = $task;
    }

    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable){
        return [
            'type' => 'nurse_task_completed',
            'message_key' => 'nurse_task_completed',

            'nurse_task_id' => $this->task->id,
            'nurse_name'   => $this->task->nurse->user->name ?? 'Nurse',
            'patient_name' => $this->task->appointment->patient->user->name ?? 'Patient',

        ];
    }


    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'nurse_task_completed',

            'nurse_task_id' => $this->task->id,
            'nurse_name'    => $this->task->nurse->user->name ?? 'Nurse',
            'patient_name'  => $this->task->appointment->patient->user->name ?? 'Patient',
        ]);
    }

}
