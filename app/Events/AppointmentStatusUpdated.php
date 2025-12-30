<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment->fresh();
    }

    public function broadcastOn() {
        $channels = collect();

        // 1️⃣ Doctor (صاحب الموعد)
        if ($this->appointment->doctor?->employee?->user_id) {
            $channels->push(
                new PrivateChannel(
                    'App.Models.User.' . $this->appointment->doctor->employee->user_id
                )
            );
        }

        // 2️⃣ Admins
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');

        // 3️⃣ Clinic Managers (نفس العيادة فقط)
        $clinicManagerIds = \App\Models\User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id);
            })->pluck('id');

        // 4️⃣ Department Managers (نفس العيادة + القسم)
        $departmentManagerIds = \App\Models\User::where('role', 'department_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                    ->where('department_id', $this->appointment->department->id);
            })->pluck('id');

        // 5️⃣ Receptionists (نفس العيادة + القسم)
        $receptionistIds = \App\Models\User::where('role', 'employee')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                ->where('department_id', $this->appointment->department->id)
                ->where('job_title', 'Receptionist');
            })->pluck('id');

        // 6️⃣ Nurses (نفس العيادة + القسم)
        $nurseIds = \App\Models\User::where('role', 'employee')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                ->where('department_id', $this->appointment->department->id)
                ->where('job_title', 'Nurse');
            })->pluck('id');

        // 7️⃣ Accountant (حسب العيادة)
        $accountantIds = \App\Models\User::where('role', 'employee')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', $this->appointment->clinic->id)
                ->where('job_title', 'Accountant');
            })->pluck('id');

        // ✨ دمج كل اليوزرز بدون تكرار
        $allUserIds = collect()
            ->merge($adminIds)
            ->merge($clinicManagerIds)
            ->merge($departmentManagerIds)
            ->merge($receptionistIds)
            ->merge($nurseIds)
            ->merge($accountantIds)
            ->unique()
            ->values();

        // تحويلهم لقنوات
        foreach ($allUserIds as $id) {
            $channels->push(new PrivateChannel("App.Models.User.$id"));
        }

        return $channels->all();
    }



    public function broadcastAs()
    {
        return 'AppointmentStatusUpdated';
    }
}
