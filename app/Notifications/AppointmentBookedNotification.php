<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification
{
    protected $appointment;
    protected $actorRole;

    public function __construct($appointment, $actorRole)
    {
        $this->appointment = $appointment;
        $this->actorRole   = $actorRole;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'appointment_booked',

            // IDs
            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            // Names
            'patient_name' => $this->appointment->patient->user->name ?? null,
            'doctor_name'  => $this->appointment->doctor->employee->user->name ?? null,

            // UI
            'icon'  => 'fa-solid fa-calendar-check',

            // ✅ CORRECT ACTOR
            'created_by_role' => $this->actorRole,
        ];
    }


    public function toBroadcast($notifiable)
    {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'appointment_booked',

            'appointment_id' => $this->appointment->id,
            'patient_id'     => $this->appointment->patient_id,
            'doctor_id'      => $this->appointment->doctor_id,

            'patient_name' => $this->appointment->patient->user->name ?? null,
            'doctor_name'  => $this->appointment->doctor->employee->user->name ?? null,

            'created_by_role' => $this->actorRole,
        ]);
    }

}
