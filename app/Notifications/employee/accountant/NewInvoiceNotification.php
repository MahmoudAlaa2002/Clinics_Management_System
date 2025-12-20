<?php

namespace App\Notifications\employee\accountant;

use Illuminate\Notifications\Notification;

class NewInvoiceNotification extends Notification {
    protected $invoice;
    protected $patientName;

    public function __construct($invoice, $patientName) {
        $this->invoice      = $invoice;
        $this->patientName  = $patientName;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toDatabase($notifiable) {
        return [
            'title' => 'New Invoice',
            'message_key' => 'new_invoice',

            'invoice_id'     => $this->invoice->id,
            'patient_name'   => $this->patientName,
            'payment_status' => $this->invoice->payment_status,

            'url' => route('accountant.details_invoice', $this->invoice->id),
            'image' => 'assets/img/invoice.png',
        ];
    }
}
