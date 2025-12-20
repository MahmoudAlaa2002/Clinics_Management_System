<?php

namespace App\Notifications\employee\nurse;

use Illuminate\Notifications\Notification;

class AppointmentCompletedNotification extends Notification {
    protected $appointment;
    protected $medicalRecord;
    protected $patientName;

    public function __construct($appointment, $medicalRecord, $patientName) {
        $this->appointment   = $appointment;
        $this->medicalRecord = $medicalRecord;
        $this->patientName   = $patientName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'Appointment Completed',
            'message_key' => 'appointment_completed',

            'appointment_id' => $this->appointment->id,
            'patient_name'   => $this->patientName,

            'url' => route('nurse.details_medical_record', $this->medicalRecord->id),
            'image' => 'assets/img/user.png',
        ];
    }
}

