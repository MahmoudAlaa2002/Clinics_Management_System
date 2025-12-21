<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Notifications\Notification;

class PatientRegisteredNotification extends Notification {

    protected Patient $patient;

    public function __construct(Patient $patient) {
        $this->patient = $patient;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'patient_registered',
            'message_key' => 'patient_registered',

            'patient_id'   => $this->patient->id,
            'patient_name' => $this->patient->user->name ?? 'Patient',

            'url' => route('profile_patient', $this->patient->id),
        ];
    }
}
