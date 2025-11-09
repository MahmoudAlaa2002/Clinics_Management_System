<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Invoice;
use Auth;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $doctor = Auth::user()->employee->doctor;

        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $appointments = $doctor->appointments()->whereBetween('date', [$start, $end])->get();

        $report = [
            'appointments' => $appointments->count(),
            'completed' => $appointments->where('status', 'Completed')->count(),
            'cancelled' => $appointments->where('status', 'Cancelled')->count(),
            'earnings' => $appointments->where('status', 'Completed')->sum('consultation_fee'),
        ];

        $chart = [
            'labels' => $appointments->groupBy(fn($a) => Carbon::parse($a->date)->format('d'))->keys(),
            'data' => $appointments->groupBy(fn($a) => Carbon::parse($a->date)->format('d'))->map->count()->values(),
        ];

        return view('Backend.doctors.reports.monthly', compact('report', 'chart'));
    }
}
