<?php

namespace App\Http\Controllers\Backend\Admin;


use Carbon\Carbon;
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

class AppointmentController extends Controller{

    public function addAppointment(){
        $patients = Patient::all();
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        return view('Backend.admin.appointments.add' , compact('patients' , 'clinics' , 'departments' , 'doctors'));
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

        $consultation_fee = Doctor::where('id', $request->doctor_id)->value('consultation_fee');

        $clinicId = Doctor::where('id', $request->doctor_id)->with('employee')->first()->employee->clinic_id;
        $linked = ClinicPatient::where('clinic_id', $clinicId)->where('patient_id', $request->patient_id)->exists();
        if (!$linked) {
            ClinicPatient::create([
                'clinic_id'  => $clinicId,
                'patient_id' => $request->patient_id,
            ]);
        }

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

        $invoice = Invoice::create([
            'appointment_id'  => $appointment->id,
            'patient_id'      => $request->patient_id,
            'total_amount'    => $consultation_fee,
            'paid_amount'     => 0,
            'payment_method'  => 'None',
            'payment_status'  => 'Unpaid',
            'invoice_date'    => now()->toDateString(),
        ]);

        return response()->json(['data' => 4]); // تم الحجز بنجاح
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
        $selectedDay = $request->appointment_day;
        $selectedTime = $request->appointment_time;

        $appointmentDate = Carbon::parse("this $selectedDay");
        if ($appointmentDate->isPast()) {
            $appointmentDate = Carbon::parse("next $selectedDay");
        }
        $appointmentDate = $appointmentDate->toDateString();

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $request->clinic_id)->where('department_id', $request->department_id)->value('id');

        $clinicId = Doctor::where('id', $request->doctor_id)->with('employee')->first()->employee->clinic_id;

        $linked = ClinicPatient::where('clinic_id', $clinicId)->where('patient_id', $request->patient_id)->exists();

        if (!$linked) {
            ClinicPatient::create([
                'clinic_id'  => $clinicId,
                'patient_id' => $request->patient_id,
            ]);
        }

        // 0️⃣ نفس الموعد موجود للمريض والدكتور
        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('clinic_department_id', $clinicDepartmentId)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        // 1️⃣ تعارض مع دكتور بنفس الوقت
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('id', '!=', $id)
            ->exists();

        if ($doctorConflict) {
            return response()->json(['data' => 1]);
        }

        // 2️⃣ موعد آخر في عيادة أخرى
        $anotherClinic = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $appointmentDate)
            ->where('time', $selectedTime)
            ->where('clinic_department_id', '!=', $clinicDepartmentId)
            ->where('id', '!=', $id)
            ->exists();

        if ($anotherClinic) {
            return response()->json(['data' => 2]);
        }

        // 3️⃣ الموعد في الماضي
        if (Carbon::parse("$appointmentDate $selectedTime")->isPast()) {
            return response()->json(['data' => 3]);
        }

        // 4️⃣ تحديث ناجح
        Appointment::findOrFail($id)->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'clinic_department_id' => $clinicDepartmentId,
            'date' => $appointmentDate,
            'time' => $selectedTime,
            'notes' => $request->notes,
            'status'=> 'Accepted',
        ]);

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
            ->orderBy('admin_deleted_at', 'desc')
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
