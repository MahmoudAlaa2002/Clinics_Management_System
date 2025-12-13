<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller{

    public function addAppointment(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;

        $patients = Patient::whereHas('clinicPatients', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->get();

        $doctors = Doctor::whereHas('employee', function ($q) use ($clinic_id , $department_id) {
            $q->where('clinic_id', $clinic_id)->where('department_id', $department_id);
        })->get();
        return view('Backend.employees.receptionists.appointments.add' , compact('clinic_id' , 'department_id' , 'patients' , 'doctors'));
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
        $appointment = Appointment::create([
            'patient_id'            => $request->patient_id,
            'doctor_id'             => $request->doctor_id,
            'clinic_department_id'  => $clinicDepartmentId,
            'date'                  => $appointmentDate,
            'time'                  => $request->appointment_time,
            'consultation_fee'      => $consultation_fee,
            'notes'                 => $request->notes,
            'status'                => 'Accepted',
        ]);

        $paidAmount = $request->paid_amount;
        $total = $consultation_fee;

        // $remaining = $total - $paidAmount;

        if ($paidAmount >= $total) {
            $paymentStatus = 'Paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'Partially Paid';
        } else {
            $paymentStatus = 'Unpaid';
        }


        $invoice = Invoice::create([
            'appointment_id'  => $appointment->id,
            'patient_id'      => $request->patient_id,
            'total_amount'    => $total,
            'paid_amount'  => $paidAmount,
            'payment_method'  => $request->payment_method,
            'payment_status'  => $paymentStatus,
            'invoice_date'    => now()->toDateString(),
            'due_date' => now()->toDateString(),
            'created_by' => Auth::user()->employee->id,
        ]);

        return response()->json(['data' => 4  , 'invoice_id' => $invoice->id]); // تم الحجز بنجاح
    }






    public function viewAppointments(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $clinic_id)->where('department_id', $department_id)->value('id');
        $appointments = Appointment::where('clinic_department_id', $clinicDepartmentId)->orderBy('id', 'asc')->paginate(50);
        return view('Backend.employees.receptionists.appointments.view', compact('appointments'));
    }



    public function searchAppointments(Request $request){
        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $clinic_id)
            ->where('department_id', $department_id)
            ->value('id');

        $keyword = trim($request->input('keyword', ''));
        $filter = $request->input('filter', '');

        $appointments = Appointment::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.clinic',
            'clinicDepartment.department'
        ])->where('clinic_department_id', $clinicDepartmentId);

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

                case 'clinic':
                    $appointments->whereHas('clinicDepartment.clinic', function ($q) use ($keyword) {
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
                          ->orWhereHas('clinicDepartment.clinic', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                          ->orWhereHas('clinicDepartment.department', fn($qq) => $qq->where('name', 'like', "%{$keyword}%"))
                          ->orWhere('date', 'like', "%{$keyword}%")
                          ->orWhere('status', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $appointments = $appointments->orderBy('id', 'asc')->paginate(50);

        $view = view('Backend.employees.receptionists.appointments.search', compact('appointments'))->render();
        $pagination = ($appointments->total() > $appointments->perPage()) ? $appointments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html' => $view,
            'pagination' => $pagination,
            'count' => $appointments->total(),
            'searching' => $keyword !== '',
        ]);
    }







    public function detailsAppointment($id){
        $appointment = Appointment::findOrFail($id);
        return view('Backend.employees.receptionists.appointments.details', compact('appointment' ));
    }





    public function editAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;

        $doctors = Doctor::whereHas('employee', function ($q) use ($clinic_id, $department_id) {
            $q->where('clinic_id', $clinic_id)
            ->where('department_id', $department_id);
        })->get();

        return view('Backend.employees.receptionists.appointments.edit', compact(
            'appointment',
            'clinic_id',
            'department_id',
            'doctors'
        ));
    }



    public function updateAppointment(Request $request, $id){
        $appointment = Appointment::findOrFail($id);

        $selectedDay  = $request->appointment_day;
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

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        // تحقق من وجود موعد مطابق لنفس المريض – استثناء الموعد الحالي
        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->where('id', '!=', $id) // استثناء هذا الموعد
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]); // المريض لديه نفس الموعد
        }

        // تعارض مع مريض آخر عند نفس الدكتور – استثناء الموعد الحالي
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->where('id', '!=', $id)
            ->exists();

        if ($conflict) {
            return response()->json(['data' => 1]); // الموعد محجوز
        }

        // لديه موعد آخر في نفس الوقت ولكن في عيادة أو قسم مختلف – استثناء الموعد الحالي
        $anotherAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->where('clinic_department_id', '!=', $clinicDepartmentId)
            ->where('id', '!=', $id)
            ->exists();

        if ($anotherAppointment) {
            return response()->json(['data' => 3]);
        }

        $consultation_fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');

        $appointment->update([
            'patient_id'            => $request->patient_id,
            'doctor_id'             => $request->doctor_id,
            'clinic_department_id'  => $clinicDepartmentId,
            'date'                  => $appointmentDate,
            'time'                  => $request->appointment_time,
            'consultation_fee'      => $consultation_fee,
            'notes'                 => $request->notes,
            'status'                => $request->status ?? $appointment->status,
        ]);

        $paid_amount = $appointment->invoice->paid_amount;

        if ($request->status === 'Cancelled') {

            $appointment->invoice->update([
                'invoice_status' => 'Cancelled',
                'paid_amount' => 0 ,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'due_date' => Null,
                'refund_amount' => $paid_amount,
            ]);
        }

        return response()->json(['data' => 4]); // تم التحديث بنجاح
    }






    public function updateStatus(Request $request, $id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;

        $paid_amount = $appointment->invoice->paid_amount;

        if ($request->status === 'Rejected') {
            $appointment->notes = 'Reject Reason: ' . $request->notes;

            $appointment->invoice->update([
                'invoice_status' => 'Cancelled',
                'paid_amount' => 0 ,
                'payment_method' => 'None',
                'payment_status' => 'Unpaid',
                'due_date' => Null,
                'refund_amount' => $paid_amount,
            ]);
        }

        $appointment->save();
        return response()->json(['success' => true]);
    }




    public function checkAppointment(Request $request){
        $selectedDay = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        $appointmentDate = Carbon::parse("this $selectedDay");

        if ($appointmentDate->isToday()) {
            $selectedDateTime = Carbon::parse($appointmentDate->toDateString() . ' ' . $selectedTime);
            if ($selectedDateTime->lt(Carbon::now())) {
                return response()->json(['data' => 2]);
            }
        } elseif ($appointmentDate->isPast()) {
            $appointmentDate = Carbon::parse("next $selectedDay");
        }

        $appointmentDate = $appointmentDate->toDateString();

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) return response()->json(['data' => 5]);

        if (Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)->exists()) {
            return response()->json(['data' => 0]);
        }

        if (Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)->exists()) {
            return response()->json(['data' => 1]);
        }

        if (Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('clinic_department_id', '!=', $clinicDepartmentId)->exists()) {
            return response()->json(['data' => 3]);
        }

        return response()->json(['data' => 4]); // أمور الموعد تمام
    }



}
