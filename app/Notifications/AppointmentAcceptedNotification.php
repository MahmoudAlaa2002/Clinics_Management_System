<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Notifications\Notification;

class AppointmentAcceptedNotification extends Notification {

    protected Appointment $appointment;

    public function __construct(Appointment $appointment) {
        $this->appointment = $appointment;
    }

    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'appointment_accepted',
            'message_key' => 'appointment_accepted',

            'appointment_id' => $this->appointment->id,
            'doctor_name' => $this->appointment->doctor->employee->user->name ?? 'Doctor',
            'clinic_name' => $this->appointment->clinic->name,
        ];
    }

    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'appointment_accepted',

            'appointment_id' => $this->appointment->id,
            'doctor_name'    => $this->appointment->doctor->employee->user->name ?? 'Doctor',
            'clinic_name'    => $this->appointment->clinic->name,
        ]);
    }

}
