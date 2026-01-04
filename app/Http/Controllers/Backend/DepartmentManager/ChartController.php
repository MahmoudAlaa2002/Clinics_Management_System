<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller {

    public function departmentPatientsMonthly() {
        $clinicId      = Auth::user()->employee->clinic_id;
        $departmentId  = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $data = Patient::selectRaw('MONTH(appointments.created_at) as m, COUNT(DISTINCT patients.id) as total')
            ->join('appointments', 'appointments.patient_id', '=', 'patients.id')
            ->join('clinic_departments', 'appointments.clinic_department_id', '=', 'clinic_departments.id')
            ->where('clinic_departments.clinic_id', $clinicId)
            ->where('clinic_departments.department_id', $departmentId)
            ->whereYear('appointments.created_at', now()->year)
            ->groupBy('m')
            ->pluck('total', 'm');

        $counts = [];
        foreach (range(1, 12) as $m) {
            $counts[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }



    public function departmentAppointmentsPerMonth() {
        $clinicId      = Auth::user()->employee->clinic_id;
        $departmentId  = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $data = Appointment::selectRaw('MONTH(created_at) as m, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', 'Completed')
            ->whereHas('clinicDepartment', function ($q) use ($clinicId, $departmentId) {
                $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
            })
            ->groupBy('m')
            ->pluck('total', 'm');

        $counts = [];
        foreach (range(1, 12) as $m) {
            $counts[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }



    public function departmentDoctorsMonthly() {
        $clinicId      = Auth::user()->employee->clinic_id;
        $departmentId  = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $data = Doctor::selectRaw('MONTH(doctors.created_at) as m, COUNT(*) as total')
            ->join('employees', 'employees.id', '=', 'doctors.employee_id')
            ->where('employees.clinic_id', $clinicId)
            ->where('employees.department_id', $departmentId)
            ->whereYear('doctors.created_at', now()->year)
            ->groupBy('m')
            ->pluck('total', 'm');

        $counts = [];
        foreach (range(1, 12) as $m) {
            $counts[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts,
        ]);
    }
}
