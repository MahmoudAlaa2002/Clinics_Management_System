<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\AppointmentBookedByReceptionist;
use App\Notifications\employee\accountant\NewInvoiceNotification;


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
        $selectedDay  = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        // حساب تاريخ الموعد
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

        // جلب clinic_department_id
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }


        /**
        * 1️⃣ تحقق: نفس الموعد تمامًا (نفس مريض + نفس دكتور + نفس قسم)
        */
        $sameAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($sameAppointment) {
            return response()->json(['data' => 0]); // المريض عنده نفس الموعد
        }

        /**
         * 2️⃣ تحقق: المريض عنده أي موعد بنفس الوقت (حتى مع دكتور آخر)
         */
        $patientBusy = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($patientBusy) {
            return response()->json(['data' => 3]); // لديه موعد آخر بنفس الوقت
        }


        /**
        * 3️⃣ تحقق: تعارض عند الطبيب
        */
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $request->appointment_time)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($doctorConflict) {
            return response()->json(['data' => 1]); // الموعد محجوز
        }

        /**
        * 4️⃣ جلب رسوم الكشف
        */
        $consultation_fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');


        /**
        * 5️⃣ إنشاء الموعد
        */
        $appointment = Appointment::create([
            'patient_id'           => $request->patient_id,
            'doctor_id'            => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date'                 => $appointmentDate,
            'time'                 => $request->appointment_time,
            'consultation_fee'     => $consultation_fee,
            'notes'                => $request->notes,
            'status'               => 'Accepted',
        ]);

        /**
        * 6️⃣ تحديد حالة الدفع
        */
        $paidAmount = $request->paid_amount ?? 0;
        $total      = $consultation_fee;

        if ($paidAmount >= $total) {
            $paymentStatus = 'Paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'Partially Paid';
        } else {
            $paymentStatus = 'Unpaid';
        }

        /**
        * 7️⃣ إنشاء الفاتورة
        */
        $invoice = Invoice::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $request->patient_id,
            'total_amount'   => $total,
            'paid_amount'    => $paidAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'invoice_date'   => now()->toDateString(),
            'due_date'       => $request->due_date,
            'created_by'     => Auth::user()->employee->id,
        ]);




        $admin = User::where('role', 'admin')->get();
        $clinicManagers = User::where('role', 'clinic_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', Auth::user()->employee->clinic_id);
            })->get();

        $departmentManagers = User::where('role', 'department_manager')
            ->whereHas('employee', function ($q) {
                $q->where('clinic_id', Auth::user()->employee->clinic_id)
                ->where('department_id', Auth::user()->employee->department_id);
            })->get();

        $doctor = User::where('role', 'doctor')
            ->whereHas('employee.doctor', function ($q) use ($appointment) {
                $q->where('id', $appointment->doctor_id);
            })->get();

        $recipients = $admin->merge($clinicManagers)->merge($departmentManagers)->merge($doctor)->unique('id');
        $receptionistName = Auth::user()->employee->user->name;
        Notification::send($recipients,new AppointmentBookedByReceptionist($appointment, $receptionistName));


        $clinic_id = Auth::user()->employee->clinic_id;
        $accountant = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($clinic_id) {
                $q->where('clinic_id', $clinic_id)->where('job_title', 'Accountant');
            })->first();

        if ($accountant) {
            Notification::send(collect([$accountant]),new NewInvoiceNotification($invoice , $appointment->patient->user->name));
        }


        /**
        * 8️⃣ نجاح
        */
        return response()->json([
            'data'       => 4,
            'invoice_id' => $invoice->id
        ]);
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

        // حساب تاريخ الموعد
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

        // جلب clinic_department_id
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        /**
         * 1️⃣ نفس الموعد تمامًا (استثناء الموعد الحالي)
         */
        $sameAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->where('id', '!=', $id)
            ->exists();

        if ($sameAppointment) {
            return response()->json(['data' => 0]);
        }

        /**
         * 2️⃣ المريض مشغول في نفس الوقت (أي دكتور) – استثناء الموعد الحالي
         */
        $patientBusy = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->where('id', '!=', $id)
            ->exists();

        if ($patientBusy) {
            return response()->json(['data' => 3]);
        }

        /**
        * 3️⃣ تعارض عند الطبيب – استثناء الموعد الحالي
        */
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->where('id', '!=', $id)
            ->exists();

        if ($doctorConflict) {
            return response()->json(['data' => 1]);
        }

        /**
        * 4️⃣ تحديث الموعد
        */
        $consultation_fee = Doctor::where('id', $request->doctor_id)
            ->value('consultation_fee');

        $appointment->update([
            'patient_id'           => $request->patient_id,
            'doctor_id'            => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date'                 => $appointmentDate,
            'time'                 => $selectedTime,
            'consultation_fee'     => $consultation_fee,
            'notes'                => $request->notes,
            'status'               => $request->status ?? $appointment->status,
        ]);

        /**
        * 5️⃣ إذا تم إلغاء الموعد → تحديث الفاتورة
        */
        if ($request->status === 'Cancelled' && $appointment->invoice) {

            $paidAmount = $appointment->invoice->paid_amount;

            $appointment->invoice->update([
                'invoice_status'  => 'Cancelled',
                'due_date'        => null,
                'refund_amount'   => $paidAmount,
            ]);
        }



        /**
        * 6️⃣ نجاح
        */
        return response()->json(['data' => 4]);
    }





    public function updateStatus(Request $request, $id){
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;

        $paid_amount = $appointment->invoice->paid_amount;

        if ($request->status === 'Rejected') {
            $appointment->notes = 'Reject Reason: ' . $request->notes;

            $appointment->invoice->update([
                'invoice_status' => 'Cancelled',
                'due_date' => Null,
                'refund_amount' => $paid_amount,
            ]);
        }

        $appointment->save();
        return response()->json(['success' => true]);
    }




    public function checkAppointment(Request $request){
        $selectedDay  = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        // حساب تاريخ الموعد
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

        // جلب clinic_department_id
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['data' => 5]); // علاقة غير موجودة
        }

        /**
         * 1️⃣ نفس الموعد تمامًا (نفس مريض + نفس دكتور + نفس قسم)
         */
        $sameAppointment = Appointment::where('patient_id', $request->patient_id)
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
         * 2️⃣ المريض مشغول في نفس الوقت (حتى مع دكتور آخر)
         */
        $patientBusy = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($patientBusy) {
            return response()->json(['data' => 3]);
        }

        /**
         * 3️⃣ تعارض عند الطبيب
         */
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->whereNotIn('status', ['Cancelled', 'Rejected'])
            ->exists();

        if ($doctorConflict) {
            return response()->json(['data' => 1]);
        }

        /**
        * 4️⃣ كل شيء تمام → افتح مودال الدفع
        */
        return response()->json(['data' => 4]);
    }

}


