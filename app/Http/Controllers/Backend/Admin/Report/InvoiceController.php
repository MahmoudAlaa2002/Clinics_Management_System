<?php

namespace App\Http\Controllers\Backend\Admin\Report;

use PDF;

use App\Models\Invoice;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller{

    public function invoicesReportsView(){
        return view('Backend.admin.reports.invoices.invoice_report_view');
    }




    public function invoicesReportsRaw(){
        $total_invoices = Invoice::count();

        $total_issued_invoices = Invoice::where('invoice_status', 'Issued')->count();
        $total_cancelled_invoices = Invoice::where('invoice_status', 'Cancelled')->count();

        $paid_invoices = Invoice::where('invoice_status', 'Issued')->where('payment_status', 'Paid')->count();
        $unpaid_invoices = Invoice::where('invoice_status', 'Issued')->where('payment_status', 'Unpaid')->count();
        $partially_paid = Invoice::where('invoice_status', 'Issued')->where('payment_status', 'Partially Paid')->count();

        $invoices_today = Invoice::whereDate('invoice_date', today())->count();

        $invoices_month = Invoice::whereMonth('invoice_date', now()->month)
            ->whereYear('invoice_date', now()->year)
            ->count();

        $days_in_month = now()->daysInMonth;
        $avg_daily_invoices = $invoices_month > 0 ? $invoices_month / $days_in_month : 0;

        $total_revenue = Invoice::sum('total_amount');

        $monthly_revenue = Invoice::whereMonth('invoice_date', now()->month)
            ->whereYear('invoice_date', now()->year)
            ->sum('total_amount');


        $paymentMethods = Invoice::selectRaw('payment_method, COUNT(*) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->toArray();


        $clinicCounts = Invoice::selectRaw('clinics.name AS clinic_name, COUNT(invoices.id) AS total')
            ->join('appointments', 'appointments.id', '=', 'invoices.appointment_id')
            ->join('clinic_departments', 'clinic_departments.id', '=', 'appointments.clinic_department_id')
            ->join('clinics', 'clinics.id', '=', 'clinic_departments.clinic_id')
            ->groupBy('clinics.name')
            ->pluck('total', 'clinic_name')
            ->toArray();

        $departmentCounts = Invoice::selectRaw('departments.name AS department_name, COUNT(invoices.id) AS total')
            ->join('appointments', 'appointments.id', '=', 'invoices.appointment_id')
            ->join('clinic_departments', 'clinic_departments.id', '=', 'appointments.clinic_department_id')
            ->join('departments', 'departments.id', '=', 'clinic_departments.department_id')
            ->groupBy('departments.name')
            ->pluck('total', 'department_name')
            ->toArray();


        $monthRevenue = Invoice::selectRaw('MONTH(invoice_date) AS month, SUM(total_amount) AS total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $best_month  = !empty($monthRevenue) ? array_search(max($monthRevenue), $monthRevenue) : null;
        $worst_month = !empty($monthRevenue) ? array_search(min($monthRevenue), $monthRevenue) : null;

        $timeCounts = Invoice::selectRaw('HOUR(invoice_date) AS hour, COUNT(*) AS total')
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        $best_time  = !empty($timeCounts) ? array_search(max($timeCounts), $timeCounts) . ":00" : null;
        $worst_time = !empty($timeCounts) ? array_search(min($timeCounts), $timeCounts) . ":00" : null;

        $pdf = PDF::loadView('Backend.admin.reports.invoices.invoice_pdf', compact(
            'total_invoices',

            'total_issued_invoices',
            'total_cancelled_invoices',
            'paid_invoices',
            'unpaid_invoices',
            'partially_paid',

            'invoices_today',
            'invoices_month',
            'avg_daily_invoices',

            'total_revenue',
            'monthly_revenue',

            'paymentMethods',
            'clinicCounts',
            'departmentCounts',

            'monthRevenue',
            'best_month',
            'worst_month',

            'best_time',
            'worst_time'
        ))->setPaper('A4', 'portrait');

        return response()->json(['pdf' => base64_encode($pdf->output())]);
    }



}
