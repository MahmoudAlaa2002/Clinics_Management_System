<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller{

    public function viewDoctors(){
        $clinic_id     = Auth::user()->employee->clinic->id;
        $department_id = Auth::user()->employee->department->id;

        $doctors = Doctor::with(['employee', 'employee.user'])
            ->whereHas('employee', function ($query) use ($clinic_id, $department_id) {
                $query->where('clinic_id', $clinic_id)
                    ->where('department_id', $department_id);
            })->orderBy('id', 'asc')->paginate(12);

        return view('Backend.departments_managers.doctors.view', compact('doctors'));
    }




    public function searchDoctors(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinic_id     = Auth::user()->employee->clinic->id;
        $department_id = Auth::user()->employee->department->id;

        $query = Doctor::with(['employee', 'employee.user'])
            ->whereHas('employee', function ($q) use ($clinic_id, $department_id) {
                $q->where('clinic_id', $clinic_id)
                ->where('department_id', $department_id);
            });

        if ($keyword !== '') {
            if ($filter === 'name') {
                $query->whereHas('employee.user', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword . '%');
                });
            } elseif ($filter === 'rating') {
                $query->whereHas('employee.doctor', function ($q) use ($keyword) {
                    $q->where('rating', 'like', $keyword . '%');
                });
            } elseif ($filter === 'status') {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('status', 'like', $keyword . '%');
                });
            } else {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('employee.user', function ($qq) use ($keyword) {
                        $qq->where('name', 'like', '%' . $keyword . '%');
                    })->orWhereHas('employee', function ($qq) use ($keyword) {
                        $qq->where('status', 'like', '%' . $keyword . '%');
                    });
                });
            }
        }

        $doctors = $query->orderBy('id')->paginate(12);
        $html = view('Backend.departments_managers.doctors.search', compact('doctors'))->render();

        return response()->json([
            'html'       => $html,
            'count'      => $doctors->total(),
            'searching'  => $keyword !== '',
            'pagination' => $doctors->links('pagination::bootstrap-4')->render(),
        ]);
    }





    public function profileDoctor($id){
        $doctor = Doctor::with([
            'employee.user',
            'employee.clinic',
            'employee.department',
            'appointments.patient.user'
        ])->findOrFail($id);
        return view('Backend.departments_managers.doctors.profile', compact('doctor'));
    }




    public function searchSchedules(){
        $clinic = Auth::user()->employee->clinic;
        $department = Auth::user()->employee->department;

        $doctors = Doctor::with(['employee', 'employee.user'])
            ->whereHas('employee', function ($query) use ($clinic, $department) {
                $query->where('clinic_id', $clinic->id)
                    ->where('department_id', $department->id);
            })->get();

        return view('Backend.departments_managers.doctors.schedules', compact(
            'clinic',
            'department',
            'doctors'
        ));
    }

    public function searchDoctchedule(Request $request){
        $clinic = Auth::user()->employee->clinic;
        $department = Auth::user()->employee->department;

        $doctor_id = $request->doctor_id;
        $offset    = (int) ($request->offset ?? 0);

        $doctors = Doctor::with(['employee', 'employee.user'])
            ->whereHas('employee', function ($query) use ($clinic, $department) {
                $query->where('clinic_id', $clinic->id)
                    ->where('department_id', $department->id);
            })->get();


        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addWeeks($offset);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addWeeks($offset);

        $appointments = Appointment::where('doctor_id', $doctor_id)->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])->get();

        return view('Backend.departments_managers.doctors.schedules', [
            'clinic'         => $clinic,
            'department'     => $department,
            'doctors'        => $doctors,
            'appointments'   => $appointments,
            'selectedDoctor' => Doctor::with('employee.user')->find($doctor_id),
            'doctor_id'      => $doctor_id,
            'offset'         => $offset,
            'startOfWeek'    => $startOfWeek,
            'endOfWeek'      => $endOfWeek,
        ]);
    }

}
