<?php

namespace App\Http\Controllers\Backend\Admin;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicPatient;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\employee\accountant\NewInvoiceNotification;
use App\Notifications\employee\receptionist\AppointmentBookedByAdmin;

class AppointmentController extends Controller{

    public function addAppointment(){
        $patients = Patient::all();
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        return view('Backend.admin.appointments.add' , compact('patients' , 'clinics' , 'departments' , 'doctors'));
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
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)
            ->where('department_id', $request->department_id)
            ->value('id');

        if (!$clinicDepartmentId) {
            return response()->json(['error' => 'Clinic-Department relation not found'], 400);
        }

        /**
        * 1️⃣ نفس الموعد تمامًا
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
        * 2️⃣ المريض مشغول بنفس الوقت (أي دكتور)
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
        * 4️⃣ جلب رسوم الكشف
        */
        $consultation_fee = Doctor::where('id', $request->doctor_id)
            ->value('consultation_fee');

        /**
        * 5️⃣ ربط المريض بالعيادة إن لم يكن مرتبطًا
        */
        $clinicId = Doctor::where('id', $request->doctor_id)
            ->with('employee')
            ->first()
            ->employee
            ->clinic_id;

        $linked = ClinicPatient::where('clinic_id', $clinicId)
            ->where('patient_id', $request->patient_id)
            ->exists();

        if (!$linked) {
            ClinicPatient::create([
                'clinic_id'  => $clinicId,
                'patient_id' => $request->patient_id,
            ]);
        }

        /**
        * 6️⃣ إنشاء الموعد
        */
        $appointment = Appointment::create([
            'patient_id'           => $request->patient_id,
            'doctor_id'            => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date'                 => $appointmentDate,
            'time'                 => $selectedTime,
            'consultation_fee'     => $consultation_fee,
            'notes'                => $request->notes,
            'status'               => 'Accepted',
        ]);

        /**
        * 7️⃣ إنشاء الفاتورة (غير مدفوعة)
        */
        $invoice = Invoice::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $request->patient_id,
            'total_amount'   => $consultation_fee,
            'paid_amount'    => 0,
            'payment_method' => 'None',
            'payment_status' => 'Unpaid',
            'invoice_date'   => now()->toDateString(),
        ]);


        $accountant = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId)
                ->where('job_title', 'Accountant');
            })->first();

        if ($accountant) {
            Notification::send(collect([$accountant]),new NewInvoiceNotification($invoice,$appointment->patient->user->name));
        }


        $receptionist = User::where('role', 'employee')
            ->whereHas('employee', function ($q) use ($clinicId, $request) {
                $q->where('clinic_id', $clinicId)
                ->where('department_id', $request->department_id)
                ->where('job_title', 'Receptionist');
            })
            ->first();

        if ($receptionist) {
            Notification::send(collect([$receptionist]),new AppointmentBookedByAdmin($appointment,$appointment->patient->user->name));
        }

        /**
        * 8️⃣ نجاح
        */
        return response()->json(['data' => 4]);
    }







    public function viewAppointments(){
        $appointments = Appointment::whereNull('admin_deleted_at') // لم يُحذف من الآدمن
            ->orderBy('id', 'asc')
            ->paginate(50);
        return view('Backend.admin.appointments.view' , compact('appointments'));
    }


    public function searchAppointments(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $appointments = Appointment::whereNull('admin_deleted_at')
        ->with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.clinic',
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

        $view = view('Backend.admin.appointments.search', compact('appointments'))->render();
        $pagination = ($appointments->total() > $appointments->perPage()) ? $appointments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $appointments->total(),
            'searching'  => $keyword !== '',
        ]);
    }






    public function detailsAppointment($id){
        $appointment = Appointment::findOrFail($id);
        return view('Backend.admin.appointments.details', compact('appointment' ));
    }





    public function editAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $clinics = Clinic::all();
        return view('Backend.admin.appointments.edit', compact('appointment' ,'clinics'));
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
         * 2️⃣ المريض مشغول بنفس الوقت (أي دكتور)
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
         * 3️⃣ تعارض عند الطبيب
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
         * 4️⃣ ربط المريض بالعيادة إن لم يكن مرتبطًا
         */
        $clinicId = Doctor::where('id', $request->doctor_id)
            ->with('employee')
            ->first()
            ->employee
            ->clinic_id;

        $linked = ClinicPatient::where('clinic_id', $clinicId)
            ->where('patient_id', $request->patient_id)
            ->exists();

        if (!$linked) {
            ClinicPatient::create([
                'clinic_id'  => $clinicId,
                'patient_id' => $request->patient_id,
            ]);
        }

        /**
         * 5️⃣ تحديث الموعد
         */
        $appointment->update([
            'patient_id'           => $request->patient_id,
            'doctor_id'            => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date'                 => $appointmentDate,
            'time'                 => $selectedTime,
            'notes'                => $request->notes,
            'status'               => $request->status ?? 'Accepted',
        ]);

        /**
         * 6️⃣ نجاح
         */
        return response()->json(['data' => 4]);
    }







    // نقل الموعد لسلة محذوفات الآدمن
    public function deleteAppointment($id){
        $appointment = Appointment::findOrFail($id);
        if ($appointment->invoice && $appointment->invoice->invoice_status !== 'Cancelled') {
            return response()->json(['data' => 0]);   // ممنوع الحذف إذا الفاتورة صادرة
        }

        // تسجيل حذف الآدمن
        $appointment->admin_deleted_at = now();
        $appointment->save();

        return response()->json(['success' => true]);
    }





    // تعرض المواعيد الموجودة في سلة المحذوفات
    public function trash(){
        $appointments = Appointment::whereNotNull('admin_deleted_at')
            ->with(['patient', 'doctor', 'invoice'])
            ->orderBy('admin_deleted_at', 'asc')
            ->paginate(50);

        return view('Backend.admin.appointments.trash.view', compact('appointments'));
    }




    // إرجاع الموعد من سلة المحذوفات
    public function restore($id){
        $appointment = Appointment::whereNotNull('admin_deleted_at')->findOrFail($id);
        $appointment->update([
            'admin_deleted_at' => null,    // إلغاء حذف الآدمن
        ]);

        return response()->json(['success' => true]);
    }




    // حذف تام
    public function forceDelete($id){
        $appointment = Appointment::whereNotNull('admin_deleted_at')->findOrFail($id);
        if ($appointment->invoice && $appointment->invoice->invoice_status !== 'Cancelled') {
            return response()->json(['data' => 0]);
        }

        if ($appointment->invoice) {
            $appointment->invoice->delete();
        }

        $appointment->forceDelete();
        return response()->json(['success' => true]);
    }




    public function searchAppointmentsTrash(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $appointments = Appointment::whereNotNull('admin_deleted_at')
        ->with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.clinic',
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

                case 'date': // البحث بتاريخ الحذف
                    $appointments->whereDate('admin_deleted_at', 'like', "{$keyword}%");
                    break;

                default:
                    $appointments->where(function ($q) use ($keyword) {

                        $q->whereHas('patient.user', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereHas('doctor.employee.user', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereHas('clinicDepartment.clinic', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereHas('clinicDepartment.department', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereDate('admin_deleted_at', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $appointments = $appointments->orderBy('admin_deleted_at', 'desc')->paginate(50);

        $view = view('Backend.admin.appointments.trash.search', compact('appointments'))->render();

        $pagination = ($appointments->total() > $appointments->perPage())
            ? $appointments->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $appointments->total(),
            'searching'  => $keyword !== '',
        ]);
    }



}
