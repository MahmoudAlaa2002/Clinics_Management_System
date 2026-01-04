<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller{


    public function viewAppointments(){
        $clinicId = Auth::user()->employee->clinic_id;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinicId)->pluck('id');
        $appointments = Appointment::whereIn('clinic_department_id', $clinicDepartmentIds)->whereNull('clinic_manager_deleted_at')
            ->with([
                'patient.user',
                'doctor.employee.user',
                'clinicDepartment.department',
                'invoice'
            ])->orderBy('id', 'asc')->paginate(50);
        return view('Backend.clinics_managers.appointments.view' , compact('appointments'));
    }


    public function searchAppointments(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinicId)->pluck('id');

        $appointments = Appointment::whereIn('clinic_department_id', $clinicDepartmentIds)
        ->whereNull('clinic_manager_deleted_at') // لم يُحذف من مدير العيادة
        ->with([
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
                          ->orWhere('date', 'like', "%{$keyword}%")
                          ->orWhere('status', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $appointments = $appointments->orderBy('id', 'asc')->paginate(50);
        $view = view('Backend.clinics_managers.appointments.search', compact('appointments'))->render();
        $pagination = $appointments->total() > 50 ? $appointments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $appointments->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function detailsAppointment($id){
        $appointment = Appointment::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.department',
            'invoice'
        ])->findOrFail($id);
        return view('Backend.clinics_managers.appointments.details', compact('appointment' ));
    }





    // ميثود نقل الموعد لسلة المحذوفات (Clinic Manager)
    public function deleteAppointment($id){
        $appointment = Appointment::findOrFail($id);

        if ($appointment->invoice && $appointment->invoice->invoice_status !== 'Cancelled') {
            return response()->json(['data' => 0]);   // منع الحذف إذا الفاتورة صادرة
        }

        // تسجيل حذف مدير العيادة
        $appointment->clinic_manager_deleted_at = now();
        $appointment->save();


        return response()->json(['success' => true]);
    }





    // تعرض المواعيد الموجودة في سلة المحذوفات
    public function trash(){
        $appointments = Appointment::whereNotNull('clinic_manager_deleted_at')
        ->with([
            'patient.user',
            'doctor.employee.user',
            'invoice'
        ])->orderBy('clinic_manager_deleted_at', 'asc')->paginate(50);

        return view('Backend.clinics_managers.appointments.trash.view', compact('appointments'));
    }




    // إرجاع الموعد من سلة المحذوفات
    public function restore($id){
        $appointment = Appointment::whereNotNull('clinic_manager_deleted_at')->findOrFail($id);
        $appointment->update([
            'clinic_manager_deleted_at' => null,   // إلغاء حذف مدير العيادة فقط
        ]);

        return response()->json(['success' => true]);
    }




    // حذف تام
    public function forceDelete($id){
        $appointment = Appointment::whereNotNull('clinic_manager_deleted_at')->findOrFail($id);
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

        $appointments = Appointment::whereNotNull('clinic_manager_deleted_at')
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

                case 'department':
                    $appointments->whereHas('clinicDepartment.department', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'date': // البحث بتاريخ الحذف
                    $appointments->whereDate('clinic_manager_deleted_at', 'like', "{$keyword}%");
                    break;

                default:
                    $appointments->where(function ($q) use ($keyword) {

                        $q->whereHas('patient.user', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereHas('doctor.employee.user', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereHas('clinicDepartment.department', fn($qq) =>
                            $qq->where('name', 'like', "%{$keyword}%"))

                        ->orWhereDate('clinic_manager_deleted_at', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $appointments = $appointments->orderBy('clinic_manager_deleted_at', 'desc')->paginate(50);

        $view = view('Backend.clinics_managers.appointments.trash.search', compact('appointments'))->render();

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
