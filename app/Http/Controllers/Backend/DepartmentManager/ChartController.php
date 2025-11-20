<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller{

    public function departmentPatientsMonthly(){
        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyPatients = Patient::whereHas('appointments', function ($q) use ($clinicId , $departmentId , $month) {
                    $q->whereHas('clinicDepartment', function ($d) use ($clinicId , $departmentId) {
                        $d->where('clinic_id', $clinicId)->where('department_id', $departmentId);
                    })
                    ->whereMonth('appointments.created_at', $month)
                    ->whereYear('appointments.created_at', now()->year);
                })
                ->distinct()
                ->count();

            $counts[] = $monthlyPatients;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }




    public function departmentAppointmentsPerMonth(){
        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $counts = [];

        for ($m = 1; $m <= 12; $m++) {
            $count = Appointment::whereMonth('created_at', $m)
                ->whereYear('created_at', now()->year)->where('status', 'Completed')
                ->whereHas('clinicDepartment', function ($q) use ($clinicId , $departmentId) {
                    $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
                })
                ->count();

            $counts[] = $count;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }


    public function departmentDoctorsMonthly(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $monthlyCounts = [];

        foreach (range(1, 12) as $month) {
            $count = Doctor::whereMonth('created_at', $month)->whereYear('created_at', now()->year)->whereHas('employee', function($q) use ($clinic_id , $departmentId) {
                        $q->where('clinic_id', $clinic_id)->where('department_id', $departmentId);
                    })->count();

            $monthlyCounts[] = $count;
        }

        return response()->json([
            'months' => $months,
            'counts' => $monthlyCounts,
        ]);
    }
}
