<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AppointmentUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        // نجيب آخر نسخة من البيانات
        $this->appointment = $appointment->fresh([
            'patient.user',
            'clinic',
            'department',
            'doctor.employee.user'
        ]);
    }

    public function broadcastOn()
{
    $channels = collect();

    // Doctor
    if ($this->appointment->doctor?->employee?->user_id) {
        $channels->push(
            new PrivateChannel(
                'App.Models.User.' . $this->appointment->doctor->employee->user_id
            )
        );
    }

    // Admins
    $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');

    // Clinic Managers
    $clinicManagerIds = \App\Models\User::where('role', 'clinic_manager')
        ->whereHas('employee', function ($q) {
            $q->where('clinic_id', $this->appointment->clinic->id);
        })->pluck('id');

    // Department Managers
    $departmentManagerIds = \App\Models\User::where('role', 'department_manager')
        ->whereHas('employee', function ($q) {
            $q->where('clinic_id', $this->appointment->clinic->id)
              ->where('department_id', $this->appointment->department->id);
        })->pluck('id');

    // Receptionists
    $receptionistIds = \App\Models\User::where('role', 'employee')
        ->whereHas('employee', function ($q) {
            $q->where('clinic_id', $this->appointment->clinic->id)
              ->where('department_id', $this->appointment->department->id)
              ->where('job_title', 'Receptionist');
        })->pluck('id');

    // Nurses
    $nurseIds = \App\Models\User::where('role', 'employee')
        ->whereHas('employee', function ($q) {
            $q->where('clinic_id', $this->appointment->clinic->id)
              ->where('department_id', $this->appointment->department->id)
              ->where('job_title', 'Nurse');
        })->pluck('id');

    // Accountant
    $accountantIds = \App\Models\User::where('role', 'employee')
        ->whereHas('employee', function ($q) {
            $q->where('clinic_id', $this->appointment->clinic->id)
              ->where('job_title', 'Accountant');
        })->pluck('id');

    $allUserIds = collect()
        ->merge($adminIds)
        ->merge($clinicManagerIds)
        ->merge($departmentManagerIds)
        ->merge($receptionistIds)
        ->merge($nurseIds)
        ->merge($accountantIds)
        ->unique()
        ->values();

    foreach ($allUserIds as $id) {
        $channels->push(new PrivateChannel("App.Models.User.$id"));
    }

    return $channels->all();
}


    public function broadcastAs()
    {
        return 'AppointmentUpdated';
    }
}
