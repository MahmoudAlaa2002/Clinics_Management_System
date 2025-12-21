<?php

namespace App\Events;

use App\Models\NurseTask;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NurseTaskAssigned {

    use Dispatchable, SerializesModels;

    public NurseTask $nurseTask;

    public function __construct(NurseTask $nurseTask) {
        $this->nurseTask = $nurseTask;
    }
}
