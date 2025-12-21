<?php

namespace App\Events;

use App\Models\Patient;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientRegistered {

    use Dispatchable, SerializesModels;

    public Patient $patient;

    public function __construct(Patient $patient) {
        $this->patient = $patient;
    }
}
