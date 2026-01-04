<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Models\Employee;

class AnalyticController extends Controller{


    public function employeesAnalytics(){
        $employees_count = Employee::count();
        $active_employees_count = Employee::where('status' , 'active')->count();
        $inactive_employees_count = Employee::where('status' , 'inactive')->count();
        $clinics_managers_count = Employee::where('job_title' , 'Clinic Manager')->count();
        $departments_managers_count = Employee::where('job_title' , 'Department Manager')->count();
        $doctors_count = Employee::where('job_title' , 'doctor')->count();
        $nurses_count = Employee::where('job_title' , 'nurse')->count();
        $receptionists_count = Employee::where('job_title' , 'receptionist')->count();
        $accountants_count = Employee::where('job_title' , 'accountant')->count();
        return view('Backend.admin.analytics.employees' , compact('employees_count',
            'active_employees_count',
            'inactive_employees_count',
            'clinics_managers_count',
            'departments_managers_count',
            'doctors_count',
            'nurses_count',
            'receptionists_count',
            'accountants_count',
        ));
    }




    public function patientsAnalytics(){
        $patients_count = Patient::count();
        $currentMonthPatients = User::where('role', 'patient')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        $completedVisits = Appointment::where('status', 'completed')->count();

        $malePatients = User::where('role', 'patient')->where('gender', 'Male')->count();
        $femalePatients = User::where('role', 'patient')->where('gender', 'Female')->count();
        $totalPatients = $malePatients + $femalePatients;

        // لتفادي القسمة على صفر
        if ($totalPatients > 0) {
            $malePercentage = round(($malePatients / $totalPatients) * 100);
            $femalePercentage = round(($femalePatients / $totalPatients) * 100);
        } else {
            $malePercentage = $femalePercentage = 0;
        }
        return view('Backend.admin.analytics.patients' , compact('patients_count',
        'currentMonthPatients',
        'completedVisits',
        'malePercentage',
        'femalePercentage'

        ));
    }





    public function appointmentsAnalytics(){
        $all_appointments = Appointment::count();
        $appointments_today = Appointment::where('date' , today())->count();
        $pending_appointments = Appointment::where('status' , 'Pending')->count();
        $accepted_appointments = Appointment::where('status' , 'Accepted')->count();
        $rejected_appointments = Appointment::where('status' , 'Rejected')->count();
        $cancelled_appointments = Appointment::where('status' , 'Cancelled')->count();
        $completed_appointments = Appointment::where('status' , 'Completed')->count();
        return view('Backend.admin.analytics.appointments' , compact(
            'all_appointments',
            'appointments_today',
            'pending_appointments',
                'accepted_appointments',
                'rejected_appointments',
                'cancelled_appointments',
                'completed_appointments',
        ));
    }





    public function invoicesAnalytics(){
        $invoices_count = Invoice::count();
        $issued_invoices = Invoice::where('invoice_status' , 'Issued')->count();
        $cancelled_invoices = Invoice::where('invoice_status' , 'Cancelled')->count();

        $partially_paid_invoices = Invoice::where('invoice_status' , 'Issued')->where('payment_status' , 'Partially Paid')->count();
        $paid_invoices = Invoice::where('invoice_status' , 'Issued')->where('payment_status' , 'Paid')->count();
        $unpaid_invoices = Invoice::where('invoice_status' , 'Issued')->where('payment_status' , 'Unpaid')->count();

        return view('Backend.admin.analytics.invoices' , compact(
            'invoices_count',
            'issued_invoices',
            'cancelled_invoices',
            'partially_paid_invoices',
            'paid_invoices',
            'unpaid_invoices',
        ));
    }





    public function doctorsAnalytics(){
        $doctors_count = Doctor::count();
        $active_doctors_count = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'active');
        })->count();

        $inactive_doctors_count = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'inactive');
        })->count();

        $department_count = Department::count();

        return view('Backend.admin.analytics.doctors' , compact('doctors_count',
            'active_doctors_count',
            'inactive_doctors_count',
            'department_count',
        ));
    }



}
