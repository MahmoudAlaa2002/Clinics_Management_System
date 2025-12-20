<?php

namespace App\Notifications\Admin;

use Illuminate\Notifications\Notification;

class AppointmentBookedByReceptionist extends Notification {

    protected $appointment;
    protected $receptionistName;

    public function __construct($appointment, $receptionistName) {
        $this->appointment = $appointment;
        $this->receptionistName = $receptionistName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Appointment Booked',
            'message_key' => 'appointment_booked_by_receptionist',
            'patient_name' => $this->appointment->patient->user->name,
            'receptionist_name' => $this->receptionistName,
            'appointment_id' => $this->appointment->id,
            'image' => 'assets/img/user.jpg',
        ];
    }
}
