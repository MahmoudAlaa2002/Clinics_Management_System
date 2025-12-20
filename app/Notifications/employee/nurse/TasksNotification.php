<?php

namespace App\Notifications\employee\nurse;

use Illuminate\Notifications\Notification;

class TasksNotification extends Notification {
    
    protected $task;
    protected $doctorName;
    protected $clinicName;

    public function __construct($task, $doctorName, $clinicName) {
        $this->task       = $task;
        $this->doctorName = $doctorName;
        $this->clinicName = $clinicName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Task Assigned',
            'message_key' => 'new_nurse_task',

            'task_id'        => $this->task->id,
            'appointment_id'=> $this->task->appointment_id,

            'doctor_name' => $this->doctorName,
            'clinic_name' => $this->clinicName,

            'url' => route('nurse.details_nurse_task', $this->task->id),
            'image' => 'assets/img/user.png',
        ];
    }
}
