<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AppointmentCompletedNotification extends Notification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'appointment_completed',

            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            'patient_name' => optional($this->appointment->patient->user)->name,
            'doctor_name'  => optional(
                optional($this->appointment->doctor)->employee?->user
            )->name,

            'icon'  => 'fa-solid fa-circle-check',
        ];
    }


    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'appointment_completed',

            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            'patient_name' => optional($this->appointment->patient->user)->name,
            'doctor_name'  => optional(
                optional($this->appointment->doctor)->employee?->user
            )->name,
        ]);
    }

}
