<?php

namespace App\Http\Controllers\Backend\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;

class ChartController extends Controller{


    public function employeesMonthly() {
        $months = [
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ];

        $data = Employee::selectRaw('MONTH(hire_date) as month, COUNT(*) as total')
            ->whereYear('hire_date', now()->year)
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $counts = [];

        foreach (range(1,12) as $m) {
            $counts[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }






    public function doctorsMonthly(){
        $monthsList = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        $doctors = Doctor::selectRaw('MONTH(employees.hire_date) as month, COUNT(doctors.id) as count')
        ->join('employees', 'employees.id', '=', 'doctors.employee_id')
        ->whereYear('employees.hire_date', now()->year) // اختياري: للسنة الحالية فقط
        ->groupBy('month')
        ->pluck('count', 'month');

        $finalCounts = [];
        foreach (range(1, 12) as $m) {
            $finalCounts[] = $doctors[$m] ?? 0;
        }

        return response()->json([
            'months' => $monthsList,
            'counts' => $finalCounts,
        ]);
    }





    public function doctorsByDepartment() {
        $data = Department::selectRaw('departments.name, COUNT(doctors.id) as total')
            ->leftJoin('employees','employees.department_id','=','departments.id')
            ->leftJoin('doctors','doctors.employee_id','=','employees.id')
            ->groupBy('departments.id','departments.name')
            ->get();

        return response()->json([
            'labels' => $data->pluck('name'),
            'counts' => $data->pluck('total'),
        ]);
    }






    public function patientsPerClinic(){
        $data = \App\Models\Clinic::selectRaw('clinics.name as clinic_name, COUNT(DISTINCT appointments.patient_id) as total_patients')
        ->leftJoin('clinic_departments', 'clinics.id', '=', 'clinic_departments.clinic_id')
        ->leftJoin('appointments', 'clinic_departments.id', '=', 'appointments.clinic_department_id')
        ->groupBy('clinics.id', 'clinics.name')
        ->get();

        $clinicNames = $data->pluck('clinic_name');
        $patientCounts = $data->pluck('total_patients');

        return response()->json([
            'clinics' => $clinicNames,
            'counts'  => $patientCounts,
        ]);
    }





    public function patientsPerMonth() {
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $data = User::where('role','patient')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $counts = [];

        foreach (range(1,12) as $m) {
            $counts[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }






    public function appointmentsMonthly() {
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $data = Appointment::selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->where('status','completed')
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $appointments = [];

        foreach (range(1,12) as $m) {
            $appointments[] = $data[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'appointments' => $appointments
        ]);
    }





    public function getAppointmentsByClinic(){
        $clinics = Clinic::get(['id', 'name']);

        $appointments = Appointment::selectRaw('clinic_department_id, COUNT(*) as total')
            ->groupBy('clinic_department_id')
            ->get();

        $clinicCounts = [];

        foreach ($clinics as $clinic) {
            $clinicDepartmentIds = ClinicDepartment::where('clinic_id', $clinic->id)->pluck('id');
            $count = $appointments->whereIn('clinic_department_id', $clinicDepartmentIds)->sum('total');

            $clinicCounts[] = [
                'name' => $clinic->name,
                'count' => $count
            ];
        }

        $colors = [
            '#007BFF', '#FF5733', '#28A745', '#FFC107', '#6F42C1', '#20C997',
            '#E83E8C', '#17A2B8', '#FD7E14', '#6610F2', '#DC3545', '#00C0A3'
        ];


        return response()->json([
            'clinics' => $clinicCounts,
            'colors'  => $colors
        ]);
    }





    public function monthlyRevenue() {
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $data = Invoice::selectRaw("
                MONTH(invoice_date) as month,
                SUM(CASE WHEN payment_status = 'Paid' THEN total_amount ELSE 0 END) +
                SUM(CASE WHEN payment_status = 'Partially Paid' THEN paid_amount ELSE 0 END)
                AS total
            ")->groupBy('month')->pluck('total','month')->toArray();

        $totals = [];

        foreach (range(1,12) as $m) {
            $totals[] = isset($data[$m]) ? floatval($data[$m]) : 0;
        }

        return response()->json([
            'months' => $months,
            'totals' => $totals
        ]);
    }







    public function revenuePerClinic() {
        $data = Clinic::selectRaw("
                clinics.name,
                COALESCE(
                    SUM(
                        CASE
                            WHEN invoices.payment_status = 'Paid'
                                THEN invoices.total_amount
                            WHEN invoices.payment_status = 'Partially Paid'
                                THEN invoices.paid_amount
                            ELSE 0
                        END
                    ),0
                ) as total
            ")->leftJoin('clinic_departments','clinic_departments.clinic_id','=','clinics.id')
            ->leftJoin('appointments','appointments.clinic_department_id','=','clinic_departments.id')
            ->leftJoin('invoices','invoices.appointment_id','=','appointments.id')
            ->groupBy('clinics.id','clinics.name')->get();

        return response()->json([
            'clinics' => $data->pluck('name'),
            'totals'  => $data->pluck('total'),
        ]);
    }





}
