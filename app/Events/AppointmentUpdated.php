<?php

namespace App\Events;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AppointmentUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public object $appointment;
    public ?int $oldDoctorUserId;

    public function __construct(Appointment $appointment, $oldDoctorUserId = null)
    {
        $this->appointment = $appointment->fresh([
            'patient.user',
            'clinic',
            'department',
            'doctor.employee.user',
        ]);

        // 👈 نرسل الدكتور القديم (لو وجد)
        $this->oldDoctorUserId = $oldDoctorUserId;
    }

    public function broadcastOn()
    {
        $channels = collect();

        /**
         * 1️⃣ Doctor الجديد
         */
        if ($this->appointment->doctor?->employee?->user_id) {
            $channels->push(
                new PrivateChannel(
                    'App.Models.User.' . $this->appointment->doctor->employee->user_id
                )
            );
        }

        /**
         * 2️⃣ Doctor القديم
         */
        if ($this->oldDoctorUserId) {
            $channels->push(
                new PrivateChannel(
                    'App.Models.User.' . $this->oldDoctorUserId
                )
            );
        }

        /**
         * 3️⃣ باقي اليوزرات (Admins + Managers + Employees…)
         */

        // Admins
        $adminIds = User::where('role', 'admin')->pluck('id');

        // Clinic Managers
        $clinicManagerIds = User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id);
            })->pluck('id');

        // Department Managers
        $departmentManagerIds = User::where('role', 'department_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                  ->where('department_id', $this->appointment->department->id);
            })->pluck('id');

        // Receptionists
        $receptionistIds = User::where('role', 'employee')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                  ->where('department_id', $this->appointment->department->id)
                  ->where('job_title', 'Receptionist');
            })->pluck('id');

        // Nurses
        $nurseIds = User::where('role', 'employee')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                  ->where('department_id', $this->appointment->department->id)
                  ->where('job_title', 'Nurse');
            })->pluck('id');

        // Accountants
        $accountantIds = User::where('role', 'employee')
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
