<?php

namespace App\Http\Controllers\Backend\Admin\Report;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class DoctorController extends Controller{

    public function doctorsReportsView(){
        return view('Backend.admin.reports.doctors.doctor_report_view');
    }



    public function doctorsReportsRaw(){
        $total_doctors = Doctor::count();
        $active_doctors = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'active');
        })->count();

        $inactive_doctors = Doctor::whereHas('employee', function ($q) {
            $q->where('status', 'inactive');
        })->count();

        $new_doctors_month = Doctor::whereHas('employee', function ($q) {
            $q->whereMonth('hire_date', now()->month)
              ->whereYear('hire_date', now()->year);
        })->count();

        $avg_doctors_monthly = Doctor::whereHas('employee', function ($q) {
            $q->where('hire_date', '>=', now()->subYear());
        })->count() / 12;

        $male_doctors = Doctor::whereHas('employee.user', function ($q) {
            $q->where('gender', 'male');
        })->count();

        $female_doctors = Doctor::whereHas('employee.user', function ($q) {
            $q->where('gender', 'female');
        })->count();

        $clinicDistribution = Doctor::selectRaw('clinics.name as clinic_name, COUNT(doctors.id) as total')
            ->join('employees', 'employees.id', '=', 'doctors.employee_id')
            ->join('clinics', 'clinics.id', '=', 'employees.clinic_id')
            ->groupBy('clinics.name')
            ->pluck('total', 'clinic_name');


        $departmentDistribution = Doctor::selectRaw('departments.name as department_name, COUNT(doctors.id) as total')
            ->join('employees', 'employees.id', '=', 'doctors.employee_id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->groupBy('departments.name')
            ->pluck('total', 'department_name');

        $pdf = PDF::loadView('Backend.admin.reports.doctors.doctor_pdf', compact('total_doctors',
            'active_doctors',
            'inactive_doctors',
            'new_doctors_month',
            'avg_doctors_monthly',
            'male_doctors',
            'female_doctors',
            'clinicDistribution',
            'departmentDistribution',
        ))->setPaper('A4', 'portrait');

        $pdfContent = $pdf->output();

        return response()->json([
            'pdf' => base64_encode($pdfContent)
        ]);
    }


}
