<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Notifications\Notification;

class AppointmentRejectedNotification extends Notification {

    protected Appointment $appointment;

    public function __construct(Appointment $appointment) {
        $this->appointment = $appointment;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'appointment_rejected',
            'message_key' => 'appointment_rejected',

            'appointment_id' => $this->appointment->id,
            'doctor_name'    => $this->appointment->doctor->employee->user->name ?? 'Doctor',
            'clinic_name'    => $this->appointment->clinic->name ?? 'Clinic',
        ];
    }
}
