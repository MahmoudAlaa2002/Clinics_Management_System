<?php

namespace App\Notifications\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientAddByReceptionist extends Notification {

    protected $patient;
    protected $receptionistName;
    protected $clinicName;

    public function __construct($patient, $receptionistName, $clinicName){
        $this->patient = $patient;
        $this->receptionistName = $receptionistName;
        $this->clinicName = $clinicName;
    }

    public function via($notifiable){
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'title' => 'New Patient Added',
            'message_key' => 'patient_added_by_receptionist',
            'patient_name' => $this->patient->user->name,
            'receptionist_name' => $this->receptionistName,
            'clinic_name' => $this->clinicName,
            'patient_id' => $this->patient->id,
            'image' => 'assets/img/user.jpg',
        ];
    }

}
