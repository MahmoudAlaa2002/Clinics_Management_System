<?php

namespace App\Events;

use App\Models\NurseTask;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NurseTaskCompleted {

    use Dispatchable, SerializesModels;

    public NurseTask $task;   // مهمة التمريض التي تم تنفيذها

    public function __construct(NurseTask $task) {
        $this->task = $task;
    }
}
