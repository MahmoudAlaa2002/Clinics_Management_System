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


    public function employeesMonthly(){
        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        $counts = [];

        for ($m = 1; $m <= 12; $m++) {
            $count = Employee::whereYear('hire_date', now()->year)->whereMonth('hire_date', $m)->count();
            $counts[] = $count;
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





    public function doctorsByDepartment(){
        $departments = Department::select('id', 'name')->get();

        $labels = [];
        $counts = [];

        foreach ($departments as $dept) {

            // نحضر عدد الدكاترة بشكل مباشر من جدول employees + doctors
            $count = Employee::where('department_id', $dept->id)
                        ->whereHas('doctor')
                        ->count();

            $labels[] = $dept->name;
            $counts[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
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





    public function patientsPerMonth(){
        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->format('M'); // Jan, Feb, Mar...
            $months[] = $monthName;

            $count = User::where('role', 'patient')->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year)->count();
            $counts[] = $count;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }





    public function appointmentsMonthly(){
        $months = [];
        $appointmentsCount = [];

        // أشهر السنة
        for ($i = 0; $i <= 11; $i++){
            $month = now()->startOfYear()->addMonths($i);

            $months[] = $month->format('M');    // اسم الشهر مثل: Jan, Feb, Mar...

            // بداية ونهاية الشهر
            $start = $month->copy()->startOfMonth();
            $end   = $month->copy()->endOfMonth();

            $appointmentsCount[] = Appointment::where('status', 'completed')->whereBetween('date', [$start, $end])->count();       // عدد المواعيد خلال الشهر
        }

        // JSON رجوع البيانات على هيئة
        return response()->json([
            'months' => $months,
            'appointments' => $appointmentsCount
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





    public function monthlyRevenue(){
        $months = [];
        $totals = [];

        for ($i = 0; $i <= 11; $i++) {

            $month = now()->startOfYear()->addMonths($i);
            $months[] = $month->format('M');

            $start = $month->copy()->startOfMonth();
            $end   = $month->copy()->endOfMonth();

            // الإيراد من الفواتير المدفوعة بالكامل
            $paidTotal = Invoice::whereBetween('invoice_date', [$start, $end])->where('payment_status', 'Paid')->sum('total_amount');

            // الإيراد من الفواتير المدفوعة جزئيًا
            $partialTotal = Invoice::whereBetween('invoice_date', [$start, $end])->where('payment_status', 'Partially Paid')->sum('paid_amount');

            // الإيراد الحقيقي للشهر
            $totals[] = floatval($paidTotal + $partialTotal);
        }

        return response()->json([
            'months' => $months,
            'totals' => $totals
        ]);
    }






    public function revenuePerClinic(){
        $clinics = Clinic::all();

        $clinicNames = [];
        $totals = [];

        foreach ($clinics as $clinic) {
            $paidTotal = Invoice::join('appointments', 'invoices.appointment_id', '=', 'appointments.id')
                ->join('clinic_departments', 'appointments.clinic_department_id', '=', 'clinic_departments.id')
                ->where('clinic_departments.clinic_id', $clinic->id)
                ->where('invoices.payment_status', 'Paid')
                ->sum('invoices.total_amount');

            $partialTotal = Invoice::join('appointments', 'invoices.appointment_id', '=', 'appointments.id')
                ->join('clinic_departments', 'appointments.clinic_department_id', '=', 'clinic_departments.id')
                ->where('clinic_departments.clinic_id', $clinic->id)
                ->where('invoices.payment_status', 'Partially Paid')
                ->sum('invoices.paid_amount');

            $total = $paidTotal + $partialTotal;

            $clinicNames[] = $clinic->name;
            $totals[] = floatval($total) ?: 0;
        }

        return response()->json([
            'clinics' => $clinicNames,
            'totals'  => $totals,
        ]);
    }




}
