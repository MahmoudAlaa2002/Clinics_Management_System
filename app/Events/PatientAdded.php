<?php

namespace App\Events;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientAdded {
    use Dispatchable, SerializesModels;

    public Patient $patient;
    public User $actor;   // الشخص الذي أضاف المريض

    public function __construct(Patient $patient, User $actor) {
        $this->patient = $patient;
        $this->actor   = $actor;
    }
}
