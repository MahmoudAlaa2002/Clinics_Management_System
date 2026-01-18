<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AppointmentAcceptedNotification extends Notification {

    protected Appointment $appointment;
    protected User $actor;

    public function __construct(Appointment $appointment, User $actor) {
        $this->appointment = $appointment;
        $this->actor = $actor;
    }

    public function via($notifiable) {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'appointment_accepted',
            'message_key' => 'appointment_accepted',

            'appointment_id' => $this->appointment->id,
            'clinic_name'    => $this->appointment->clinic->name,
            'doctor_name'    => $this->appointment->doctor->employee->user->name ?? 'Doctor',

            'actor_id'   => $this->actor->id,
            'actor_role' => $this->actor->role,
            'actor_name' => $this->actor->name,
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'type' => 'appointment_accepted',

            'appointment_id' => $this->appointment->id,
            'clinic_name'    => $this->appointment->clinic->name,
            'doctor_name'    => $this->appointment->doctor->employee->user->name ?? 'Doctor',

            'actor_id'   => $this->actor->id,
            'actor_role' => $this->actor->role,
            'actor_name' => $this->actor->name,
        ]);
    }
}


