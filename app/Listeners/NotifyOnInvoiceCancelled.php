<?php

namespace App\Listeners;

use App\Events\InvoiceCancelled;
use App\Models\User;
use App\Notifications\InvoiceCancelledNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnInvoiceCancelled {

    public function handle(InvoiceCancelled $event): void {
        $invoice = $event->invoice;

        $accountants = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($invoice) {
                $q->where('clinic_id', $invoice->appointment->clinic->id)
                  ->where('job_title', 'Accountant');
            })->get();

        if ($accountants->isEmpty()) {
            return;
        }

        Notification::send($accountants,new InvoiceCancelledNotification($invoice));
    }
}
