<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller{

    public function viewReports(){
        return view('Backend.departments_managers.reports.view');
    }




    public function detailsPatientsReports(){
        $clinicId = Auth::user()->employee->clinic_id;
        $departmentId = Auth::user()->employee->department_id;

        $patients_count = Patient::whereHas('appointments.clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
        })->count();

        $patients_current_month = Patient::whereHas('appointments', function ($q) use ($clinicId , $departmentId) {
            $q->whereHas('clinicDepartment', function ($d) use ($clinicId , $departmentId) {
                $d->where('clinic_id', $clinicId)->where('department_id', $departmentId);
            })
            ->whereMonth('appointments.created_at', now()->month)
            ->whereYear('appointments.created_at', now()->year);
        })
        ->distinct()
        ->count();


        $completed_visits = Patient::whereHas('appointments', function ($q) use ($clinicId , $departmentId) {
            $q->whereHas('clinicDepartment', function ($d) use ($clinicId , $departmentId) {
                $d->where('clinic_id', $clinicId)->where('department_id', $departmentId);
            })
            ->where('status', 'Completed');
        })->count();


        $male_patients_count = Patient::whereHas('user', function ($u) {
            $u->where('gender', 'male');
        })
        ->whereHas('appointments', function ($q) use ($clinicId , $departmentId) {
            $q->whereHas('clinicDepartment', function ($d) use ($clinicId , $departmentId) {
                $d->where('clinic_id', $clinicId)->where('department_id', $departmentId);
            });
        })->distinct()->count();



        $female_patients_count = Patient::whereHas('user', function ($u) {
            $u->where('gender', 'female');
        })
        ->whereHas('appointments', function ($q) use ($clinicId , $departmentId) {
            $q->whereHas('clinicDepartment', function ($d) use ($clinicId , $departmentId) {
                $d->where('clinic_id', $clinicId)->where('department_id', $departmentId);
            });
        })->distinct()->count();

        $total_patients_gender = $male_patients_count + $female_patients_count;

        $male_percentage = $total_patients_gender > 0 ? round(($male_patients_count / $total_patients_gender) * 100, 1) : 0;

        $female_percentage = $total_patients_gender > 0 ? round(($female_patients_count / $total_patients_gender) * 100, 1) : 0;

        return view('Backend.departments_managers.reports.details.patients_reports' , compact('patients_count',
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
        $departmentId = Auth::user()->employee->department_id;

        $appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
        })->count();

        $pending_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
        })->where('status' , 'Pending')->count();

        $completed_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
        })->where('status' , 'Completed')->count();

        $cancelled_appointments_count = Appointment::whereHas('clinicDepartment', function ($q) use ($clinicId , $departmentId) {
            $q->where('clinic_id', $clinicId)->where('department_id', $departmentId);
        })->where('status' , 'Cancelled')->count();

        return view('Backend.departments_managers.reports.details.appointments_reports' , compact('appointments_count',
            'pending_appointments_count',
            'completed_appointments_count',
            'cancelled_appointments_count',
        ));
    }





    public function detailsDoctorsReports(){
        $clinic = Auth::user()->employee->clinic;
        $departmentId = Auth::user()->employee->department_id;

        $doctor_count = Doctor::whereHas('employee', function($q) use ($clinic , $departmentId) {
            $q->where('clinic_id', $clinic->id)->where('department_id', $departmentId);
        })->count();

        $top_doctors_count = Doctor::whereHas('employee', function($q) use ($clinic , $departmentId) {
            $q->where('clinic_id', $clinic->id)->where('department_id', $departmentId);
        })->where('rating' , 5)->count();

        $active_doctor_count = Doctor::whereHas('employee', function($q) use ($clinic , $departmentId) {
            $q->where('clinic_id', $clinic->id)->where('department_id', $departmentId)->where('status', 'active');
        })->count();

        $inactive_doctor_count = Doctor::whereHas('employee', function($q) use ($clinic , $departmentId) {
            $q->where('clinic_id', $clinic->id)->where('department_id', $departmentId)->where('status', 'inactive');
        })->count();

        return view('Backend.departments_managers.reports.details.doctors_reports' , compact('doctor_count',
            'active_doctor_count',
            'inactive_doctor_count',
            'top_doctors_count',
        ));
    }


}
