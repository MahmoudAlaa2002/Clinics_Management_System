<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\User;
use App\Notifications\InvoiceCreatedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnInvoiceCreated {

    public function handle(InvoiceCreated $event): void {
        $invoice = $event->invoice;

        // ================== المستلمين ==================
        $accountants = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($invoice) {
                $q->where('clinic_id', $invoice->appointment->clinic->id)
                  ->where('job_title', 'Accountant');
            })->get()->unique('id')->values();



        // ================== إرسال الإشعار ==================
        Notification::send($accountants,new InvoiceCreatedNotification($invoice)
        );
    }
}
