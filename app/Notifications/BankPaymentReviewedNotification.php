<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\BankPayment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class BankPaymentReviewedNotification extends Notification {

    protected BankPayment $payment;
    protected User $actor;
    protected string $status;

    public function __construct(BankPayment $payment, User $actor, string $status) {
        $this->payment = $payment;
        $this->actor   = $actor;
        $this->status  = $status;
    }

    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable) {

        $hold = $this->payment->hold;

        return [
            'type'        => 'bank_payment_reviewed',
            'message_key' => 'bank_payment_reviewed',

            'payment_id'  => $this->payment->id,
            'status'      => $this->status,

            'clinic_name' => $hold?->clinicDepartment?->clinic?->name,
            'doctor_name' => $hold?->doctor?->employee?->user?->name,

            'actor_id'    => $this->actor->id,
            'actor_role'  => $this->actor->role,
            'actor_name'  => $this->actor->name,
        ];
    }

    public function toBroadcast($notifiable) {

        $hold = $this->payment->hold;

        return new BroadcastMessage([
            'type'        => 'bank_payment_reviewed',
            'message_key' => 'bank_payment_reviewed',
            'status'      => $this->status,

            'payment_id'  => $this->payment->id,

            'clinic_name' => $hold?->clinicDepartment?->clinic?->name,
            'doctor_name' => $hold?->doctor?->employee?->user?->name,

            'actor_id'    => $this->actor->id,
            'actor_role'  => $this->actor->role,
            'actor_name'  => $this->actor->name,
        ]);
    }
}
