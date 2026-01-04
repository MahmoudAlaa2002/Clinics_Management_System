<?php

namespace App\Http\Controllers\Backend\Admin\Report;

use PDF;
use App\Models\Appointment;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller{

    public function appointmentsReportsView(){
        return view('Backend.admin.reports.appointments.appointments_report_view');
    }




    public function appointmentsReportsRaw(){
        $total_appointments = Appointment::count();

        $completed_appointments = Appointment::where('status', 'Completed')->count();
        $cancelled_appointments = Appointment::where('status', 'Cancelled')->count();
        $rejected_appointments  = Appointment::where('status', 'Rejected')->count();
        $accepted_appointments  = Appointment::where('status', 'Accepted')->count();
        $pending_appointments   = Appointment::where('status', 'Pending')->count();

        $appointments_today = Appointment::whereDate('date', today())->count();

        $appointments_month = Appointment::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $days_in_month = now()->daysInMonth;
        $avg_daily_appointments = $appointments_month > 0 ? $appointments_month / $days_in_month : 0;

        $statusCounts = Appointment::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $clinicCounts = Appointment::selectRaw('clinics.name AS clinic_name, COUNT(appointments.id) AS total')
            ->join('clinic_departments', 'clinic_departments.id', '=', 'appointments.clinic_department_id')
            ->join('clinics', 'clinics.id', '=', 'clinic_departments.clinic_id')
            ->groupBy('clinics.name')
            ->pluck('total', 'clinic_name')
            ->toArray();

        $departmentCounts = Appointment::selectRaw('departments.name AS department_name, COUNT(appointments.id) AS total')
            ->join('clinic_departments', 'clinic_departments.id', '=', 'appointments.clinic_department_id')
            ->join('departments', 'departments.id', '=', 'clinic_departments.department_id')
            ->groupBy('departments.name')
            ->pluck('total', 'department_name')
            ->toArray();

        $monthCounts = Appointment::selectRaw('MONTH(date) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $most_active_month  = !empty($monthCounts) ? array_search(max($monthCounts), $monthCounts) : null;
        $least_active_month = !empty($monthCounts) ? array_search(min($monthCounts), $monthCounts) : null;

        $timeCounts = Appointment::selectRaw('HOUR(time) AS hour, COUNT(*) AS total')
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        $best_time_slot  = !empty($timeCounts) ? array_search(max($timeCounts), $timeCounts) . ":00" : null;
        $worst_time_slot = !empty($timeCounts) ? array_search(min($timeCounts), $timeCounts) . ":00" : null;

        $dailyCounts = Appointment::selectRaw('DAY(date) as day, COUNT(*) as total')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $most_busy_day  = !empty($dailyCounts) ? array_search(max($dailyCounts), $dailyCounts) : null;
        $least_busy_day = !empty($dailyCounts) ? array_search(min($dailyCounts), $dailyCounts) : null;

        $pdf = PDF::loadView('Backend.admin.reports.appointments.appointments_pdf', compact(
            'total_appointments',
            'completed_appointments',
            'cancelled_appointments',
            'rejected_appointments',
            'accepted_appointments',
            'pending_appointments',

            'appointments_today',
            'appointments_month',
            'avg_daily_appointments',

            'statusCounts',
            'clinicCounts',
            'departmentCounts',

            'most_active_month',
            'least_active_month',

            'best_time_slot',
            'worst_time_slot',

            'dailyCounts',
            'most_busy_day',
            'least_busy_day'
        ))->setPaper('A4', 'portrait');

        return response()->json(['pdf' => base64_encode($pdf->output())]);
    }




}
