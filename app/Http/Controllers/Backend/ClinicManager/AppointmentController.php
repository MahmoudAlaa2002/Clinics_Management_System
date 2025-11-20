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


    public function viewAppointments(){
        $clinicId = Auth::user()->employee->clinic_id;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinicId)->pluck('id');
        $appointments = Appointment::whereIn('clinic_department_id', $clinicDepartmentIds)->orderBy('id', 'asc')->paginate(12);
        return view('Backend.clinics_managers.appointments.view' , compact('appointments'));
    }


    public function searchAppointments(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;
        $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinicId)->pluck('id');

        $appointments = Appointment::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment.department'
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





    public function deleteAppointment($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['success' => true]);
    }
}
