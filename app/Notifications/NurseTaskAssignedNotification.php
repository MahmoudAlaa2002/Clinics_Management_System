<?php

namespace App\Notifications;

use App\Models\NurseTask;
use Illuminate\Notifications\Notification;

class NurseTaskAssignedNotification extends Notification {

    protected NurseTask $task;

    public function __construct(NurseTask $task) {
        $this->task = $task;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'nurse_task_assigned',
            'message_key' => 'nurse_task_assigned',
            'nurse_task_id' => $this->task->id,
            'appointment_id' => $this->task->appointment_id,
            'doctor_name' => $this->task->appointment->doctor->employee->user->name,
            'status' => $this->task->status,
            'image' => 'assets/img/nurse-task.png',
        ];
    }
}
