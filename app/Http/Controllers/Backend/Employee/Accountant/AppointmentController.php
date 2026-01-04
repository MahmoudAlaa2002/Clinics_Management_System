<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller{

    public function viewAppointments(){
        $clinic = Auth::user()->employee->clinic;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinic->id)->pluck('id');
        $appointments = Appointment::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.department'
        ])->whereIn('clinic_department_id', $clinicDepartmentIds)->orderBy('id', 'asc')->paginate(50);
        return view('Backend.employees.accountants.appointments.view' , compact('appointments' , 'clinic'));
    }


    public function searchAppointments(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinicId)->pluck('id');

        $appointments = Appointment::with([
            'patient.user',
            'doctor.employee.user',
        ])->whereIn('clinic_department_id', $clinicDepartmentIds);

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
        $view = view('Backend.employees.accountants.appointments.search', compact('appointments'))->render();
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
            'clinicDepartment.department'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.appointments.details', compact('appointment' ));
    }
}
