<?php

namespace App\Listeners;

use App\Events\AppointmentBooked;
use App\Models\User;
use App\Notifications\AppointmentBookedNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOnAppointmentBooked {

    public function handle(AppointmentBooked $event): void {
        $appointment = $event->appointment;
        $actor = $event->actor; // الشخص الذي حجز
        $actorId = $actor?->id;
        $actorRole = $actor?->role;

        // المستلمين حسب قواعدك
        $recipients = collect();

        // Admin
        $admins = User::where('role', 'admin')->get();

        //  Clinic Manager (نفس العيادة)
        $clinicManagers = User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) use ($appointment) {
                $q->where('clinic_id', $appointment->clinic->id);
            })->get();

        // Department Manager (نفس العيادة + نفس القسم)
        $departmentManagers = User::where('role', 'department_manager')
            ->whereHas('employee', function ($q) use ($appointment) {
                $q->where('clinic_id', $appointment->clinic->id)
                  ->where('department_id', $appointment->department->id);
            })->get();

        // Doctor
        $doctor = User::whereHas('employee.doctor', function ($q) use ($appointment) {
            $q->where('id', $appointment->doctor_id);
        })->get();

        // Patient
        $patient = User::whereHas('patient', function ($q) use ($appointment) {
            $q->where('id', $appointment->patient_id);
        })->get();

        // Receptionist (حسب نظامك: نفس القسم + نفس العيادة)
        $receptionists = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($appointment) {
                $q->where('clinic_id', $appointment->clinic->id)
                  ->where('department_id', $appointment->department->id)
                  ->where('job_title', 'Receptionist');
            })->get();


        // ====== قواعد الإرسال حسب من قام بالحجز ======

        if ($actorRole === 'admin') {
            // Admin حجز => لا تبعث للـ Admin
            $recipients = $recipients
                ->merge($clinicManagers)
                ->merge($departmentManagers)
                ->merge($doctor)
                ->merge($receptionists)
                ->merge($patient);
        }
        elseif ($actorRole === 'receptionist') {
            // Receptionist حجز => لا تبعث للـ Receptionist
            $recipients = $recipients
                ->merge($admins)
                ->merge($clinicManagers)
                ->merge($departmentManagers)
                ->merge($doctor)
                ->merge($patient);
        }
        else {
            // أي سيناريو آخر (مريض مثلا) => ابعث للجميع حسب سياستك
            $recipients = $recipients
                ->merge($admins)
                ->merge($clinicManagers)
                ->merge($departmentManagers)
                ->merge($doctor)
                ->merge($receptionists);
        }

        // إزالة التكرار + إزالة الشخص اللي عمل الحجز (احتياط)
        $recipients = $recipients
            ->unique('id')
            ->when($actorId, fn ($c) => $c->reject(fn ($u) => $u->id === $actorId))
            ->values();

            Notification::send($recipients,new AppointmentBookedNotification($appointment, $actorRole));
    }
}
