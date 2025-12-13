<?php

namespace App\Http\Controllers\Backend\Admin\Report;

use PDF;
use App\Models\Clinic;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller{


    public function employeesReportsView(){
        return view('Backend.admin.reports.employees.employee_report_view');
    }


    public function employeesReportsRaw(){
        $total_employees = Employee::count();
        $active_employees = Employee::where('status' , 'active')->count();
        $inactive_employees = Employee::where('status' , 'inactive')->count();

        $new_hires_month = Employee::whereYear('hire_date', now()->year)->whereMonth('hire_date', now()->month)->count();
        $avg_monthly_hires = Employee::where('hire_date', '>=', now()->subYear())->count() / 12;
        $avg_monthly_hires = round($avg_monthly_hires, 2);

        $clinic_manager_employees = Employee::where('job_title' , 'Clinic Manager')->count();
        $department_employees = Employee::where('job_title' , 'Department Manager')->count();
        $doctor_employees = Employee::where('job_title' , 'Doctor')->count();
        $nurse_employees = Employee::where('job_title' , 'Nurse')->count();
        $receptionist_employees = Employee::where('job_title' , 'Receptionist')->count();

        $male_employees = Employee::whereHas('user', function ($q) {
            $q->where('gender', 'Male');
        })->count();

        $female_employees = Employee::whereHas('user', function ($q) {
            $q->where('gender', 'Female');
        })->count();

        $ageDist = $this->getEmployeesAgeDistribution();
        $age_18_25   = $ageDist['age_18_25'];
        $age_26_35   = $ageDist['age_26_35'];
        $age_36_45   = $ageDist['age_36_45'];
        $age_46_60   = $ageDist['age_46_60'];
        $age_60_plus = $ageDist['age_60_plus'];

        $clinicEmployeeCounts = Clinic::withCount('employees')->get()->pluck('employees_count', 'name')->toArray();

        $pdf = PDF::loadView('Backend.admin.reports.employees.employee_pdf', compact('total_employees',
            'active_employees',
            'inactive_employees',
            'new_hires_month',
            'avg_monthly_hires',
            'clinic_manager_employees',
            'department_employees',
            'doctor_employees',
            'nurse_employees',
            'receptionist_employees',
            'male_employees',
            'female_employees',
            'age_18_25',
            'age_26_35',
            'age_36_45',
            'age_46_60',
            'age_60_plus',
            'clinicEmployeeCounts',
        ))->setPaper('A4', 'portrait');

        return response()->json(['pdf' => base64_encode($pdf->output())]);
    }





    public function getEmployeesAgeDistribution(){
        $age_18_25 = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 18 AND 25')
            ->count();

        $age_26_35 = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 26 AND 35')
            ->count();

        $age_36_45 = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 36 AND 45')
            ->count();

        $age_46_60 = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 46 AND 60')
            ->count();

        $age_60_plus = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) >= 61')
            ->count();

        return [
            'age_18_25'   => $age_18_25,
            'age_26_35'   => $age_26_35,
            'age_36_45'   => $age_36_45,
            'age_46_60'   => $age_46_60,
            'age_60_plus' => $age_60_plus,
        ];
    }





}
