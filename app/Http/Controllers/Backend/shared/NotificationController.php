<?php

namespace App\Http\Controllers\Backend\Shared;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller{

    public function read($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $data = $notification->data;
        $user = auth()->user();

        if (!empty($data['message_key'])) {
            switch ($data['message_key']) {
                case 'patient_added_by_receptionist':
                    return match ($user->role) {
                        'admin' => redirect()->route('profile_patient', $data['patient_id']),

                        'clinic_manager' => redirect()->route('clinic.profile_patient',$data['patient_id']),

                        default => redirect()->route('dashboard'),
                    };

                case 'appointment_booked_by_receptionist':
                    return match ($user->role) {
                        'admin' => redirect()->route('details_appointment', $data['appointment_id']),

                        'clinic_manager' => redirect()->route('clinic.details_appointment',$data['appointment_id']),

                        'department_manager' => redirect()->route('department.details_appointment',$data['appointment_id']),

                        'doctor' => redirect()->route('doctor.appointment.show',$data['appointment_id']),

                        default => redirect()->route('dashboard'),
                    };
            }
        }

        // 🔹 السلوك القديم (لكل الإشعارات الأخرى)
        return redirect(
            $data['url'] ?? route('dashboard')
        );
    }


}
