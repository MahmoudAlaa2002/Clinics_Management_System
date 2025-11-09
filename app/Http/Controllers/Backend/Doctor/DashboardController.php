<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function doctorDashboard()
{
    $doctor = Auth::user()->employee->doctor;

    $months = [];
    $appointmentsPerMonth = [];
    $completedPerMonth = [];
    $cancelledPerMonth = [];

    // آخر 6 شهور
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $start = $month->startOfMonth()->toDateString();
        $end = $month->endOfMonth()->toDateString();

        $appointmentsPerMonth[] = $doctor->appointments()
            ->whereBetween('date', [$start, $end])->count();

        $completedPerMonth[] = $doctor->appointments()
            ->whereBetween('date', [$start, $end])
            ->where('status', 'Completed')
            ->count();

        $cancelledPerMonth[] = $doctor->appointments()
            ->whereBetween('date', [$start, $end])
            ->where('status', 'Cancelled')
            ->count();

        $pendingPerMonth[] = $doctor->appointments()
            ->whereBetween('date', [$start, $end])
            ->where('status', 'Pending')
            ->count();

        $acceptedPerMonth[] = $doctor->appointments()
            ->whereBetween('date', [$start, $end])
            ->where('status', 'Accepted')
            ->count();

        $months[] = $month->format('M');
    }

    return view('Backend.doctors.dashboard', [
        'allAppointments' => $doctor->appointments()->count(),
        'pendingAppointments' => $doctor->appointments()->where('status', 'Pending')->count(),
        'completedAppointments' => $doctor->appointments()->where('status', 'Completed')->count(),
        'totalPatients' => $doctor->patients()->distinct('patients.id')->count('patients.id'),
        'todayAppointments' => $doctor->appointments()->whereDate('date', today())->count(),
        'monthlyEarnings' => $doctor->appointments()
            ->where('status', 'Completed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('consultation_fee'),
        'totalEarnings' => $doctor->appointments()
            ->where('status', 'Completed')
            ->sum('consultation_fee'),
        'months' => $months,
        'appointmentsPerMonth' => $appointmentsPerMonth,
        'completedPerMonth' => $completedPerMonth,
        'cancelledPerMonth' => $cancelledPerMonth,
        'pendingPerMonth' => $pendingPerMonth,
        'acceptedPerMonth' => $acceptedPerMonth,
    ]);
}

}
