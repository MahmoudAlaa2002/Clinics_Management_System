<?php

namespace App\Notifications\employee\receptionist;

use Illuminate\Notifications\Notification;

class AppointmentBookedByAdmin extends Notification {

    protected $appointment;
    protected $adminName;

    public function __construct($appointment, $adminName) {
        $this->appointment = $appointment;
        $this->adminName   = $adminName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Appointment Booked',
            'message_key' => 'appointment_booked_by_admin',

            'appointment_id' => $this->appointment->id,
            'patient_name'   => $this->appointment->patient->user->name,
            'admin_name'     => $this->adminName,

            'url' => route('receptionist.details_appointment', $this->appointment->id),
            'image' => 'assets/img/user.png',
        ];
    }
}
