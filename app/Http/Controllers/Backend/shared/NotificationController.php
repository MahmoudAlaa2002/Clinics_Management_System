<?php

namespace App\Http\Controllers\Backend\Shared;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller{

    public function read($id) {
        $user = auth()->user();

        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $type = $notification->data['type'] ?? null;

        return redirect($this->redirectByNotificationType($user, $notification, $type)
        );
    }



    protected function redirectByNotificationType($user, $notification, $type) {
        return match ($type) {

            // 📅 حجز موعد
            'appointment_booked' =>
                $this->redirectAppointment($user, $notification),

            // ❌ إلغاء موعد
            'appointment_cancelled' =>
                $this->redirectAppointment($user, $notification),

            // ✅ إنهاء موعد
            'appointment_completed' =>
                $this->redirectAppointment($user, $notification),

            // 🧾 فاتورة جديدة
            'invoice_created' =>
                $this->redirectInvoice($user, $notification),

            // 👩‍⚕️ مهمة تمريض
            'nurse_task_assigned' =>
                $this->redirectNurseTask($user, $notification),

            // 👩‍⚕️  إنشاء حساب مريض
            'patient_registered' =>
                $this->redirectPatientRegistered($user, $notification),

            // 👩‍⚕️ إضافة مريض
            'patient_added' =>
                $this->redirectPatientAdded($user, $notification),

            // اكتمال مهمة المريض
            'nurse_task_completed' =>
                $this->redirectNurseTaskCompleted($user, $notification),


            default => route('dashboard'),
        };
    }



    protected function redirectAppointment($user, $notification) {
        $appointmentId = $notification->data['appointment_id'] ?? null;

        if ($user->role === 'admin') {
            return route('details_appointment', $appointmentId);
        }

        if ($user->role === 'doctor') {
            return route('doctor.appointment.show', $appointmentId);
        }

        if ($user->role === 'clinic_manager') {
            return route('clinic.details_appointment', $appointmentId);
        }

        if ($user->role === 'department_manager') {
            return route('department.details_appointment', $appointmentId);
        }

        if ($user->role === 'employee' && optional($user->employee)->job_title === 'Receptionist') {
            return route('receptionist.details_appointment', $appointmentId);
        }

        if ($user->role === 'employee' && optional($user->employee)->job_title === 'Nurse') {
            return route('nurse.view_appointments', $appointmentId);
        }

        if ($user->role === 'patient') {
            // return route('patient.details_appointment', $appointmentId);
        }

        return route('dashboard');
    }


    protected function redirectInvoice($user, $notification) {
        $invoiceId = $notification->data['invoice_id'] ?? null;

        if ($user->role === 'employee' && optional($user->employee)->job_title === 'Accountant') {
            return route('accountant.details_invoice', $invoiceId);
        }

        return route('dashboard');
    }


    protected function redirectNurseTask($user, $notification) {

        // رقم مهمة التمريض
        $taskId = $notification->data['nurse_task_id'] ?? null;

        // فقط للممرض
        if ($user->role === 'employee' && optional($user->employee)->job_title === 'Nurse') {
            return route('nurse.details_nurse_task', $taskId);
        }

        // أي شخص آخر
        return route('dashboard');
    }

    protected function redirectPatientRegistered($user, $notification) {

        $patientId = $notification->data['patient_id'] ?? null;

        if ($user->role === 'admin' && $patientId) {
            return route('profile_patient', $patientId);
        }

        // أي شخص آخر
        return route('dashboard');
    }

    protected function redirectPatientAdded($user, $notification) {
        $patientId = $notification->data['patient_id'] ?? null;

        if (!$patientId) {
            return route('dashboard');
        }

        if ($user->role === 'admin') {
            return route('profile_patient', $patientId);
        }

        if ($user->role === 'clinic_manager') {
            return route('clinic.profile_patient', $patientId);
        }

        if ($user->role === 'employee' && optional($user->employee)->job_title === 'Receptionist') {
            return route('receptionist.profile_patient', $patientId);
        }

        // أي شخص آخر
        return route('dashboard');
    }

    protected function redirectNurseTaskCompleted($user, $notification) {
        $taskId = $notification->data['nurse_task_id'] ?? null;

        if ($user->role === 'doctor' && $taskId) {
            return route('doctor.nurse_task', $taskId);
        }

        return route('dashboard');
    }



}
