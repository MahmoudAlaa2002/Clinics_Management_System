<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AppointmentCancelledNotification extends Notification {

    protected $appointment;
    protected $actorRole;

    public function __construct($appointment, string $actorRole) {
        $this->appointment = $appointment;
        $this->actorRole   = $actorRole;
    }


    public function via($notifiable): array {
        return ['database', 'broadcast'];
    }


    public function toDatabase($notifiable): array {
        return [
            'type' => 'appointment_cancelled',

            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            'patient_name' => optional($this->appointment->patient->user)->name,
            'doctor_name'  => optional(optional($this->appointment->doctor)->employee?->user)->name,

            // من قام بالإلغاء
            'cancelled_by' => $this->actorRole,

            'icon'  => 'fa-solid fa-calendar-xmark',

        ];
    }


    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'appointment_cancelled',

            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            'patient_name' => optional($this->appointment->patient->user)->name,
            'doctor_name'  => optional(optional($this->appointment->doctor)->employee?->user)->name,

            'cancelled_by' => $this->actorRole,
        ]);
    }

}
