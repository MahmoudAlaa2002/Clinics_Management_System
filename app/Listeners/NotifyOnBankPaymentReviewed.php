<?php

namespace App\Listeners;

use App\Events\BankPaymentReviewed;
use App\Notifications\BankPaymentReviewedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnBankPaymentReviewed {

    public function handle(BankPaymentReviewed $event): void {

        $payment = $event->payment;
        $actor   = $event->actor;
        $status  = $event->status;

        
        $patientUser = $payment->appointment?->patient?->user;
        if (! $patientUser) return;

        Notification::send(
            $patientUser,
            new BankPaymentReviewedNotification($payment, $actor, $status)
        );
    }
}
