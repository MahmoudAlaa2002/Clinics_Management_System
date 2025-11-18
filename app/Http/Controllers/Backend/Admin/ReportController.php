<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class ReportController extends Controller{

    public function viewReports(){
        return view('Backend.admin.reports.view');
    }



    public function detailsPatientsReports(){
        $patients_count = Patient::count();
        $currentMonthPatients = User::where('role', 'patient')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        $completedVisits = Appointment::where('status', 'completed')->count();

        $malePatients = User::where('role', 'patient')->where('gender', 'male')->count();
        $femalePatients = User::where('role', 'patient')->where('gender', 'female')->count();
        $totalPatients = $malePatients + $femalePatients;

        // لتفادي القسمة على صفر
        if ($totalPatients > 0) {
            $malePercentage = round(($malePatients / $totalPatients) * 100);
            $femalePercentage = round(($femalePatients / $totalPatients) * 100);
        } else {
            $malePercentage = $femalePercentage = 0;
        }
        return view('Backend.admin.reports.details.patients_reports' , compact('patients_count',
        'currentMonthPatients',
        'completedVisits',
        'malePercentage',
        'femalePercentage'

        ));
    }





    public function detailsAppointmentsReports(){
        $all_appointments = Appointment::count();
        $pending_appointments = Appointment::where('status' , 'Pending')->count();
        $completed_appointments = Appointment::where('status' , 'Completed')->count();
        $cancelled_appointments = Appointment::where('status' , 'Cancelled')->count();
        return view('Backend.admin.reports.details.appointments_reports' , compact('all_appointments',
            'pending_appointments',
                'completed_appointments',
                'cancelled_appointments'
        ));
    }





    public function detailsInvoicesReports(){
        $invoices_count = Invoice::count();
        $partially_paid_invoices = Invoice::where('payment_status' , 'Partially Paid')->count();
        $paid_invoices = Invoice::where('payment_status' , 'Paid')->count();
        $unpaid_invoices = Invoice::where('payment_status' , 'Unpaid')->count();

        return view('Backend.admin.reports.details.invoices_reports' , compact('invoices_count',
            'partially_paid_invoices',
            'paid_invoices',
            'unpaid_invoices',
        ));
    }





    public function detailsDoctorsReports(){
        $doctors_count = Doctor::count();
        $active_doctors_count = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'active');
        })->count();

        $inactive_doctors_count = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'inactive');
        })->count();

        $department_count = Department::count();

        return view('Backend.admin.reports.details.doctors_reports' , compact('doctors_count',
            'active_doctors_count',
            'inactive_doctors_count',
            'department_count',
        ));
    }
}
