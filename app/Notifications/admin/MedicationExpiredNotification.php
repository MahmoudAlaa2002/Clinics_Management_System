<?php

namespace App\Notifications\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicationExpiredNotification extends Notification{
    use Queueable;

    private $medication;

    public function __construct($medication){
        $this->medication = $medication;
    }

    public function via($notifiable){
        return ['database'];
    }

    public function toArray($notifiable){
        return [
            'message' => '⚠️ The medication ' . $this->medication->name .
                        ' has expired on ' . $this->medication->expiry_date,
            'medication_id' => $this->medication->id,
            'image'         => 'assets/img/expired.png',
            'url' => route('notifications_details_medication_read', $this->medication->id),
        ];
    }
}
