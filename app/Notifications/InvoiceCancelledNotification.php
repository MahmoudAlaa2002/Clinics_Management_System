<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class InvoiceCancelledNotification extends Notification {
    protected Invoice $invoice;

    public function __construct(Invoice $invoice) {
        $this->invoice = $invoice;
    }

    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'invoice_cancelled',
            'message_key' => 'invoice_cancelled',

            'invoice_id'   => $this->invoice->id,
            'patient_name'=> $this->invoice->patient->user->name ?? 'Patient',
            'amount'      => $this->invoice->total_amount,
            'status'      => 'Cancelled',
        ];
    }


    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'invoice_cancelled',
            'invoice_id'   => $this->invoice->id,
            'patient_name' => $this->invoice->patient->user->name ?? 'Patient',
            'amount'       => $this->invoice->total_amount,
            'status'       => 'Cancelled',
        ]);
    }
}
