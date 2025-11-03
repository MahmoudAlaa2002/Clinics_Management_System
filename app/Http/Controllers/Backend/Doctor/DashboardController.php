<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function doctorDashboard(){

        $doctor = Auth::user()->employee->doctor;

        $allAppointments = $doctor->appointments()->count();
        $completedAppointments = $doctor->appointments()->where('status', 'Completed')->count();
        $todayAppointments = $doctor->appointments()->whereDate('date', '=', today())->count();
        $pendingAppointments = $doctor->appointments()->where('status', 'Pending')->count();
        $totalPatients = $doctor->patients()->distinct('patients.id')->count('patients.id');
        $monthlyErnings = $doctor->appointments()
            ->where('status', 'Completed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('consultation_fee');

        return view ('Backend.doctors.dashboard', compact(
            'allAppointments',
            'completedAppointments',
            'todayAppointments',
            'pendingAppointments',
            'totalPatients',
            'monthlyErnings'
        ));
    }
}
