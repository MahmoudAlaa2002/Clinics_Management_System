<?php

namespace App\Notifications\Admin;

use Illuminate\Notifications\Notification;

class PatientRegisteredNotification extends Notification {

    protected $patient;

    public function __construct($patient) {
        $this->patient = $patient;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Patient Registered',
            'message_key' => 'patient_registered',

            'patient_name' => $this->patient->user->name,
            'patient_id'   => $this->patient->id,

            'url'   => route('profile_patient', $this->patient->id),
            'image' => 'assets/img/user.jpg',
        ];
    }
}
