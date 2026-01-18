<?php

namespace App\Http\Controllers\Backend\Patient;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentHold;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller{

    public function myAppointments(){
        $patientId = auth()->user()->patient->id;
        $appointments = Appointment::where('patient_id', $patientId)->with([
                'clinic',
                'department',
                'doctor.employee.user'
            ])->orderBy('date', 'desc')->paginate(12);

        return view('Backend.patients.appointments.myAppointments', compact('appointments'));
    }





    public function detailsAppointment($id) {
        $appointment = Appointment::with([
            'patient.user',
            'clinic',
            'department',
            'doctor.employee.user',
            'invoice'
        ])->findOrFail($id);

        return view('Backend.patients.appointments.details', compact('appointment'));
    }






    public function appointmentBookClinic(Clinic $clinic) {
        $clinics = Clinic::all();
        return view('Backend.patients.appointments.makeAnAppointment', [
            'clinics' => $clinics,
            'clinic' => $clinic
        ]);
    }


    public function appointmentBookDoctor(Doctor $doctor) {
        $clinics = Clinic::all();
        return view('Backend.patients.appointments.makeAnAppointment', [
            'clinics' => $clinics,
            'clinic' => $doctor->employee->clinic,
            'department' => $doctor->employee->department_id,
            'doctorId' => $doctor->id
        ]);
    }


    public function createHold(Request $request) {
        $patientId = auth()->user()->patient->id;

        // نفس حساب اليوم/الوقت عندك
        $selectedDay  = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        $appointmentDate = Carbon::parse("this $selectedDay");
        if ($appointmentDate->isToday()) {
            $selectedDateTime = Carbon::parse($appointmentDate->toDateString() . ' ' . $selectedTime);
            if ($selectedDateTime->lt(now())) {
                return response()->json(['data' => -1]);
            }
        } elseif ($appointmentDate->isPast()) {
            $appointmentDate = Carbon::parse("next $selectedDay");
        }
        $appointmentDate = $appointmentDate->toDateString();

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        $sameAppointment = Appointment::where('patient_id', $patientId)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($sameAppointment) {
            return response()->json(['data' => 0]);
        }

        /**
         * 2️⃣ المريض مشغول بنفس الوقت
         */
        $patientBusy = Appointment::where('patient_id', $patientId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($patientBusy) {
            return response()->json(['data' => 1]);
        }

        // تعارض مع Appointments الموجودة (محجوز فعليًا)
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($doctorConflict) return response()->json(['data' => 2]);

        
        // تعارض مع Holds أخرى غير منتهية
        $holdConflict =AppointmentHold::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('status', 'Pending')
            ->where('expires_at', '>', now())
            ->exists();

        if ($holdConflict) return response()->json(['data' => 2]);

        $fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');

        // إنشاء Hold لمدة 10 دقائق
        try {
            $hold = AppointmentHold::create([
                'patient_id'           => $patientId,
                'doctor_id'            => $request->doctor_id,
                'clinic_department_id' => $clinicDepartmentId,
                'date'                 => $appointmentDate,
                'time'                 => $selectedTime,
                'amount'               => $fee,
                'expires_at'           => now()->addMinutes(10),
                'status'               => 'Pending',
            ]);

            return response()->json([
                'ok' => true,
                'hold_id' => $hold->id
            ]);

        } catch (\Throwable $e) {
            // لو ضرب unique بسبب سباق
            return response()->json(['data' => 2]);
        }
    }

}
