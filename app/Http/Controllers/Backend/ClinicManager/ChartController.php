<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\ClinicPatient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller {

    // عدد المرضى شهريًا
    public function clinicPatientsMonthly() {
        $clinicId = Auth::user()->employee->clinic_id;

        $patients = ClinicPatient::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT patient_id) as total')
            ->where('clinic_id', $clinicId)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $counts = [];

        foreach (range(1, 12) as $m) {
            $months[] = date("M", mktime(0, 0, 0, $m, 1));
            $counts[] = $patients[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }


    // عدد المواعيد شهريًا
    public function clinicAppointmentsPerMonth() {
        $clinicId = Auth::user()->employee->clinic_id;

        $appointments = Appointment::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->whereHas('clinicDepartment', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            })
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $counts = [];

        foreach (range(1, 12) as $m) {
            $months[] = date("M", mktime(0, 0, 0, $m, 1));
            $counts[] = $appointments[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }

    // عدد الأطباء شهريًا
    public function clinicDoctorsMonthly(){
        $clinic_id = Auth::user()->employee->clinic_id;

        $doctors = Doctor::join('employees', 'doctors.employee_id', '=', 'employees.id')
            ->where('employees.clinic_id', $clinic_id)
            ->whereYear('employees.hire_date', now()->year)
            ->selectRaw('MONTH(employees.hire_date) as month, COUNT(doctors.id) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $counts = [];

        foreach (range(1, 12) as $m) {
            $months[] = date("M", mktime(0, 0, 0, $m, 1));
            $counts[] = $doctors[$m] ?? 0;
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts,
        ]);
    }




    // أرباح العيادة شهريًا
    public function clinicMonthlyRevenue() {
        $clinic = Auth::user()->employee->clinic;

        $monthlyTotals = Invoice::selectRaw('MONTH(invoice_date) as month, SUM(invoices.paid_amount) as total')
            ->whereHas('appointment.clinicDepartment', function ($q) use ($clinic) {
                $q->where('clinic_id', $clinic->id);
            })
            ->whereIn('payment_status', ['Paid', 'Partially Paid'])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $totals = [];

        foreach (range(1, 12) as $m) {
            $months[] = date("M", mktime(0, 0, 0, $m, 1));
            $totals[] = optional($monthlyTotals->firstWhere('month', $m))->total ?? 0;
        }

        return response()->json([
            'months' => $months,
            'totals' => $totals
        ]);
    }
}
