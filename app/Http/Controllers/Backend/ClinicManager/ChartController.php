<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller{

    public function clinicPatientsMonthly(){
        $clinicId = Auth::user()->employee->clinic_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyPatients = Patient::whereHas('appointments', function ($q) use ($clinicId, $month) {
                    $q->whereHas('clinicDepartment', function ($d) use ($clinicId) {
                        $d->where('clinic_id', $clinicId);
                    })
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year);
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

    public function clinicAppointmentsPerMonth(){
        $clinicId = Auth::user()->employee->clinic_id;

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $counts = [];

        for ($m = 1; $m <= 12; $m++) {
            $count = Appointment::whereMonth('created_at', $m)
                ->whereYear('created_at', now()->year)
                ->whereHas('clinicDepartment', function ($q) use ($clinicId) {
                    $q->where('clinic_id', $clinicId);
                })
                ->count();

            $counts[] = $count;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }


    public function clinicDoctorsMonthly(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $monthlyCounts = [];
        foreach (range(1, 12) as $month) {
            $count = Doctor::whereMonth('created_at', $month)->whereHas('employee', function($q) use ($clinic_id) {
                        $q->where('clinic_id', $clinic_id);
                    })->count();

            $monthlyCounts[] = $count;
        }

        return response()->json([
            'months' => $months,
            'counts' => $monthlyCounts,
        ]);
    }


    public function clinicMonthlyRevenue(){
        $clinic = Auth::user()->employee->clinic;
        $monthlyTotals = Invoice::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
                $q->where('clinic_id', $clinic->id);
            })->where('payment_status', 'Paid')->groupBy('month')->orderBy('month')->get();

        $allMonths = collect(range(1, 12));

        $months = [];
        $totals = [];

        foreach ($allMonths as $m) {
            $months[] = date("M", mktime(0, 0, 0, $m, 1));
            $totals[] = optional($monthlyTotals->firstWhere('month', $m))->total ?? 0;
        }

        return response()->json([
            'months' => $months,
            'totals' => $totals
        ]);
    }


}
