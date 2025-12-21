<?php

namespace App\Notifications;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Notifications\Notification;

class PatientAddedNotification extends Notification {

    protected Patient $patient;
    protected User $actor;

    public function __construct(Patient $patient, User $actor) {
        $this->patient = $patient;
        $this->actor   = $actor;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'patient_added',
            'message_key' => 'patient_added',

            'patient_id'   => $this->patient->id,
            'patient_name' => $this->patient->user->name ?? 'Patient',

            'actor_id'   => $this->actor->id,
            'actor_role' => $this->actor->role,
            'actor_name' => $this->actor->name,
        ];
    }
}
