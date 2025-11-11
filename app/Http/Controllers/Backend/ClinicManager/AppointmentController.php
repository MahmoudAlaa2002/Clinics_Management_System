<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller{

    public function addAppointment(){
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $employees = $clinic->employees;
        $doctors = Doctor::whereIn('employee_id', $employees->pluck('id'))->get();
        $patients = Patient::all();
        return view('Backend.clinics_managers.appointments.add' , compact('patients' , 'clinic' , 'departments' , 'doctors'));
    }


    public function storeAppointment(Request $request){
        $selectedDay = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        $appointmentDate = Carbon::parse("this $selectedDay");

        if ($appointmentDate->isToday()) {
            $selectedDateTime = Carbon::parse($appointmentDate->toDateString() . ' ' . $selectedTime);
            if ($selectedDateTime->lt(Carbon::now())) {
                return response()->json(['data' => 2]); // الوقت انتهى
            }
        } elseif ($appointmentDate->isPast()) {
            $appointmentDate = Carbon::parse("next $selectedDay");
        }

        $appointmentDate = $appointmentDate->toDateString();

        //  أولاً: نحضر رقم العلاقة من جدول الوصلة
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        // تحقق من وجود موعد سابق لنفس المريض والدكتور والقسم
        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]); // المريض عنده نفس الموعد
        }

        // تحقق من وجود تعارض مع مريض آخر عند نفس الدكتور
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->exists();

        if ($conflict) {
            return response()->json(['data' => 1]); // الموعد محجوز
        }

        $anotherAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->where('clinic_department_id', '!=', $clinicDepartmentId)
            ->exists();

        if ($anotherAppointment) {
            return response()->json(['data' => 3]); // لديه موعد في عيادة أخرى أو قسم آخر بنفس الوقت
        }

        // احضار رسوم الكشف
        $consultation_fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');

        // إنشاء الموعد الجديد
        Appointment::create([
            'patient_id'            => $request->patient_id,
            'doctor_id'             => $request->doctor_id,
            'clinic_department_id'  => $clinicDepartmentId,
            'date'                  => $appointmentDate,
            'time'                  => $request->appointment_time,
            'consultation_fee'      => $consultation_fee,
            'notes'                 => $request->notes,
            'status'                => 'Pending',
        ]);

        return response()->json(['data' => 4]); // تم الحجز بنجاح
    }






    public function viewAppointments(){
        $appointments = Appointment::orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.appointments.view' , compact('appointments'));
    }


    public function searchAppointments(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $appointments = Appointment::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.department'
        ]);

        if ($keyword !== '') {
            switch ($filter) {
                case 'patient':
                    $appointments->whereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'doctor':
                    $appointments->whereHas('doctor.employee.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'department':
                    $appointments->whereHas('clinicDepartment.department', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'date':
                    $appointments->where('date', 'like', "{$keyword}%");
                    break;

                case 'status':
                    $appointments->where('status', 'like', "{$keyword}%");
                    break;

                default:
                    $appointments->where(function ($q) use ($keyword) {
                        $q->whereHas('patient.user', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                        ->orWhereHas('doctor.employee.user', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                        ->orWhereHas('clinicDepartment.department', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                        ->orWhere('date', 'like', "%{$keyword}%")
                        ->orWhere('status', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $appointments = $appointments->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.clinics_managers.appointments.search', compact('appointments'))->render();
        $pagination = $appointments->total() > 12 ? $appointments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $appointments->total(),
            'searching'  => $keyword !== '',
        ]);
    }






    public function detailsAppointment($id){
        $appointment = Appointment::findOrFail($id);
        return view('Backend.clinics_managers.appointments.details', compact('appointment' ));
    }





    public function editAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $clinic = Auth::user()->employee->clinic;
        $departments = $clinic->departments;
        $employees = $clinic->employees;
        $doctors = Doctor::whereIn('employee_id', $employees->pluck('id'))->get();
        return view('Backend.clinics_managers.appointments.edit', compact( 'appointment' , 'departments' , 'doctors'));
    }


    public function updateAppointment(Request $request, $id){
        $selectedDay = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        // تحديد تاريخ الموعد (نفس منطق الإضافة)
        $appointmentDate = Carbon::parse("this $selectedDay");

        if ($appointmentDate->isToday()) {
            $selectedDateTime = Carbon::parse($appointmentDate->toDateString() . ' ' . $selectedTime);
            if ($selectedDateTime->lt(Carbon::now())) {
                return response()->json(['data' => 2]); // الوقت انتهى
            }
        } elseif ($appointmentDate->isPast()) {
            $appointmentDate = Carbon::parse("next $selectedDay");
        }

        $appointmentDate = $appointmentDate->toDateString();

        // رقم العلاقة بين العيادة والقسم
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        // 0. تحقق من وجود نفس الموعد لنفس المريض والدكتور والقسم
        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('id', '!=', $id) // تجاهل هذا الموعد
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]); // المريض لديه نفس الموعد
        }

        // 1. الموعد محجوز لمريض آخر عند نفس الدكتور
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('id', '!=', $id)
            ->exists();

        if ($conflict) {
            return response()->json(['data' => 1]); // الموعد محجوز
        }

        // 3. لديه موعد آخر في عيادة أخرى بنفس الوقت
        $anotherAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('clinic_department_id', '!=', $clinicDepartmentId)
            ->where('id', '!=', $id)
            ->exists();

        if ($anotherAppointment) {
            return response()->json(['data' => 3]); // لديه موعد آخر
        }

        // 4. تحديث الموعد بنجاح
        Appointment::findOrFail($id)->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date' => $appointmentDate,
            'time' => $selectedTime,
            'notes' => $request->notes,
        ]);

        return response()->json(['data' => 4]); // نجاح
    }







    public function deleteAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['success' => true]);
    }
}
