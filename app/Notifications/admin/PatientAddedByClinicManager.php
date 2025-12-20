<?php

namespace App\Notifications\Admin;

use Illuminate\Notifications\Notification;

class PatientAddedByClinicManager extends Notification {

    protected $patient;
    protected $clinicName;
    protected $clinicManagerName;

    public function __construct($patient, $clinicManagerName, $clinicName) {
        $this->patient = $patient;
        $this->clinicManagerName = $clinicManagerName;
        $this->clinicName = $clinicName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Patient Added',
            'message_key' => 'patient_added_by_clinic_manager',

            'patient_name' => $this->patient->user->name,
            'clinic_manager_name' => $this->clinicManagerName,
            'clinic_name' => $this->clinicName,

            'patient_id' => $this->patient->id,
            'url' => route('profile_patient', $this->patient->id),
            'image' => 'assets/img/user.jpg',
        ];
    }
}
