<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Notification;

class InvoiceCreatedNotification extends Notification {

    protected Invoice $invoice;
    protected string $patientName;

    public function __construct(Invoice $invoice) {
        $this->invoice = $invoice;
        $this->patientName = $invoice->patient->user->name ?? 'Patient';
    }

    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => 'invoice_created',
            'message_key'  => 'invoice_created',
            'invoice_id'   => $this->invoice->id,
            'patient_name' => $this->patientName,
            'amount'       => $this->invoice->amount,
            'payment_status'       => $this->invoice->payment_status,
        ];
    }


    public function toBroadcast($notifiable) {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'type' => 'invoice_created',

            'invoice_id'   => $this->invoice->id,
            'patient_name' => $this->patientName,
            'amount'       => $this->invoice->amount,
            'payment_status' => $this->invoice->payment_status,
        ]);
    }

}
