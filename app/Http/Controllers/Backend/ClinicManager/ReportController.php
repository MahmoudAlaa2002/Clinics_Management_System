<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use Auth;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicPatient;
use App\Http\Controllers\Controller;

class ReportController extends Controller{

    public function viewReports(){
        return view('Backend.clinics_managers.reports.view');
    }




    public function detailsPatientsReports(){
        $clinic = Auth::user()->employee->clinic;

        $patients_count = $clinic->patients()->count();

        $patients_current_month = $clinic->patients()
            ->whereMonth('clinic_patients.created_at', now()->month)
            ->whereYear('clinic_patients.created_at', now()->year)
            ->count();

        // عدد المرضى الذين زياراتهم مكتملة
        $completed_visits = Patient::whereHas('appointments', function ($q) use ($clinic) {
            $q->whereHas('clinicDepartment', function ($d) use ($clinic) {
                $d->where('clinic_id', $clinic->id);
            })
            ->where('status', 'Completed');
        })->count();

        $male_patients_count = ClinicPatient::join('patients', 'clinic_patients.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('clinic_patients.clinic_id', $clinic->id)
            ->where('users.gender', 'Male')
            ->distinct('patients.id')
            ->count('patients.id');

        // عدد المرضى الإناث
        $female_patients_count = ClinicPatient::join('patients', 'clinic_patients.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('clinic_patients.clinic_id', $clinic->id)
            ->where('users.gender', 'Female')
            ->distinct('patients.id')
            ->count('patients.id');

        $total_patients_gender = $male_patients_count + $female_patients_count;

        // حساب النسب
        $male_percentage = $total_patients_gender > 0 ? round(($male_patients_count / $total_patients_gender) * 100, 1) : 0;

        $female_percentage = $total_patients_gender > 0 ? round(($female_patients_count / $total_patients_gender) * 100, 1) : 0;

        return view('Backend.clinics_managers.reports.details.patients_reports' , compact('patients_count',
            'patients_current_month',
                'completed_visits',
                'male_patients_count',
                'female_patients_count',
                'male_percentage',
                'female_percentage',

        ));
    }




    public function detailsAppointmentsReports(){
        $clinicId = Auth::user()->employee->clinic_id;
        $appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        })->count();

        $pending_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        })->where('status' , 'Pending')->count();

        $completed_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        })->where('status' , 'Completed')->count();

        $cancelled_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        })->where('status' , 'Cancelled')->count();

        return view('Backend.clinics_managers.reports.details.appointments_reports' , compact('appointments_count',
            'pending_appointments_count',
            'completed_appointments_count',
            'cancelled_appointments_count',
        ));
    }




    public function detailsInvoicesReports(){
        $clinic = Auth::user()->employee->clinic;

        $invoices_count = Invoice::whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();


        $issued_invoices_count = Invoice::where('invoice_status' , 'Issued')->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();

        $cancelled_invoices_count = Invoice::where('invoice_status' , 'Cancelled')->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();

        $paid_invoices_count = Invoice::where('invoice_status' , 'Issued')->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->where('payment_status', 'Paid')->count();

        $partially_paid_invoices_count = Invoice::where('invoice_status' , 'Issued')->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->where('payment_status', 'Partially Paid')->count();


        $unpaid_invoices_count = Invoice::where('invoice_status' , 'Issued')->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->where('payment_status', 'Unpaid')->count();


        return view('Backend.clinics_managers.reports.details.invoices_reports' , compact(
            'invoices_count',
            'issued_invoices_count',
            'cancelled_invoices_count',
            'paid_invoices_count',
            'partially_paid_invoices_count',
            'unpaid_invoices_count',
        ));
    }





    public function detailsDoctorsReports(){
        $clinic = Auth::user()->employee->clinic;
        $doctor_count = Doctor::whereHas('employee', function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->count();

        $active_doctor_count = Doctor::whereHas('employee', function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id)->where('status', 'active');
        })->count();

        $inactive_doctor_count = Doctor::whereHas('employee', function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id)->where('status', 'inactive');
        })->count();

        $departments_count = $clinic->departments()->count();

        return view('Backend.clinics_managers.reports.details.doctors_reports' , compact('doctor_count',
            'active_doctor_count',
            'inactive_doctor_count',
            'departments_count',
        ));
    }
}
