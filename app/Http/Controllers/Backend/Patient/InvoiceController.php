<?php

namespace App\Http\Controllers\Backend\Patient;

use PDF;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller {

    public function invoicesView(){
        $patient = Auth::user()->patient;
        $invoices = $patient->invoices()->with([
                'appointment.doctor.employee.user',
                'appointment.clinic'
            ])->orderBy('invoice_date', 'desc')->paginate(10);

        return view('Backend.patients.invoices.view', compact('patient', 'invoices'));
    }




    public function detailsInvoice($id){
        $invoice = Invoice::with([
                'appointment.doctor.employee.user',
                'appointment.clinic'
            ])->findOrFail($id);

        return view('Backend.patients.invoices.details', compact('invoice'));
    }




    public function invoicePDF($id){
        $invoice = Invoice::findOrFail($id);
        return view('Backend.patients.invoices.invoice_pdf' , compact('invoice'));
    }


    public function invoicePDFRaw($id){
        $invoice = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);
        $pdf = PDF::loadView('Backend.patients.invoices.invoice_pdf_raw', compact('invoice'))->setPaper('A4', 'portrait');
        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }




    // الفواتير الملغية بنعرض فاتورة إرجاع مالي بدلا من الفاتورة الملغية

    public function detailsRefundInvoice($id){
        $refund_invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.patients.invoices.cancelled.details', compact('refund_invoice'));
    }




    public function cancelledinvoicePDF($id){
        $refund_invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.patients.invoices.cancelled.invoice_pdf' , compact('refund_invoice'));
    }




    public function cancelledinvoicePDFRaw($id){
        $refund_invoice  = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);

        $pdf = PDF::loadView('Backend.patients.invoices.cancelled.invoice_pdf_raw', compact('refund_invoice'))->setPaper('A4', 'portrait');

        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }
}
