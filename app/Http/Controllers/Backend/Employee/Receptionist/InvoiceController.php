<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use PDF;
use Auth;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller {

    public function viewInvoices(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;

        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $clinic_id)->where('department_id', $department_id)->value('id');
        $invoices = Invoice::whereHas('appointment', function($q) use ($clinicDepartmentId) {
            $q->where('clinic_department_id', $clinicDepartmentId);
        })->where('invoice_status', 'Issued')->orderBy('id', 'asc')->paginate(50);

        return view('Backend.employees.receptionists.invoices.view', compact('invoices'));
    }


    public function searchInvoices(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinic_id = Auth::user()->employee->clinic_id;
        $department_id = Auth::user()->employee->department_id;
        $clinicDepartmentId = ClinicDepartment::where('clinic_id', $clinic_id)->where('department_id', $department_id)->value('id');

        $invoices = Invoice::with(['patient.user', 'appointment'])
        ->whereHas('appointment', function($q) use ($clinicDepartmentId) {
            $q->where('clinic_department_id', $clinicDepartmentId);
        });

        if ($keyword !== '') {
            switch ($filter) {

                case 'appointment_id':
                    $invoices->where('appointment_id', 'like', "{$keyword}%");
                    break;

                case 'patient_name':
                    $invoices->whereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "{$keyword}%");
                    });
                    break;

                case 'invoice_date':
                    $invoices->where('invoice_date', 'like', "{$keyword}%");
                    break;

                case 'due_date':
                    $invoices->where('due_date', 'like', "{$keyword}%");
                    break;

                case 'payment_status':
                    $invoices->where('payment_status', 'like', "{$keyword}%");
                    break;

                case 'invoice_status':
                    $invoices->where('invoice_status', 'like', "{$keyword}%");
                    break;

                default:
                    $invoices->where(function ($q) use ($keyword) {
                        $q->where('appointment_id', 'like', "%{$keyword}%")
                        ->orWhere('invoice_date', 'like', "%{$keyword}%")
                        ->orWhere('due_date', 'like', "%{$keyword}%")
                        ->orWhere('payment_status', 'like', "%{$keyword}%")
                        ->orWhereHas('patient.user', function ($qq) use ($keyword) {
                            $qq->where('name', 'like', "%{$keyword}%");
                        });
                    });
                    break;
            }
        }

        $invoices = $invoices->orderBy('id', 'asc')->paginate(50);
        $view = view('Backend.employees.receptionists.invoices.search', compact('invoices'))->render();
        $pagination = ($invoices->total() > $invoices->perPage()) ? $invoices->links('pagination::bootstrap-4')->render() : '';


        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $invoices->total(),
            'searching'  => $keyword !== '',
        ]);
    }




    public function detailsInvoice($id){
        $invoice = Invoice::findOrFail($id);
        return view('Backend.employees.receptionists.invoices.details', compact('invoice'));
    }




    public function invoicePDF($id){
        $invoice = Invoice::findOrFail($id);
        return view('Backend.employees.receptionists.invoices.invoice_pdf' , compact('invoice'));
    }


    public function invoicePDFRaw($id){
        $invoice = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);

        $pdf = PDF::loadView('Backend.employees.receptionists.invoices.invoice_pdf_raw', compact('invoice'))->setPaper('A4', 'portrait');

        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }
}
