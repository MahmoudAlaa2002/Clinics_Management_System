<?php

namespace App\Notifications\Admin;

use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification {  // بدي أخليها لما المريض يضيف موعد من نفسه

    protected $appointment;

    public function __construct($appointment) {
        $this->appointment = $appointment;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Appointment Booked',
            'message_key' => 'appointment_booked',

            'patient_name' => $this->appointment->patient->user->name,
            'appointment_id' => $this->appointment->id,

            'url' => route('details_appointment', $this->appointment->id),
            'image' => 'assets/img/user.jpg',
        ];
    }
}
