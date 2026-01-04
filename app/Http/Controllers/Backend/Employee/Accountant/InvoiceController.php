<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use PDF;
use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller{


    public function viewInvoices(Request $request){
        $clinic_id = Auth::user()->employee->clinic_id;
        $statusFilter = $request->input('invoiceFilter', 'Issued');

        $invoices = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment'
        ])->whereHas('appointment.clinicDepartment', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->when($statusFilter, function ($query) use ($statusFilter) {
            return $query->where('invoice_status', $statusFilter);
        })->orderBy('id','asc')->paginate(50);

        return view('Backend.employees.accountants.invoices.view', compact('invoices' , 'statusFilter'));
    }


    public function searchInvoices(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');
        $statusFilter = $request->invoiceFilter ?? 'Issued';


        $header = '<tr>
                <th>ID</th>
                <th>Appointment ID</th>
                <th>Patient Name</th>';

        if ($statusFilter === 'Issued') {
            $header .= '
                <th>Invoice Date</th>
                <th>Due Date</th>';
        } else {
            $header .= '
                <th>Refund Amount</th>
                <th>Refund Date</th>';
        }

        $header .= '
                <th>Payment Status</th>
                <th>Action</th>
            </tr>';


        $clinic_id = Auth::user()->employee->clinic_id;

        $invoices = Invoice::with(['patient.user', 'appointment.clinicDepartment'])
            ->whereHas('appointment.clinicDepartment', function ($query) use ($clinic_id) {
                $query->where('clinic_id', $clinic_id);
            });


        if ($statusFilter) {
            $invoices->where('invoice_status', $statusFilter);
        }

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

                case 'refund_date':
                    $invoices->where('refund_date', 'like', "{$keyword}%");
                    break;

                case 'payment_status':
                    $invoices->where('payment_status', 'like', "{$keyword}%");
                    break;

                default:
                    $invoices->where(function ($q) use ($keyword) {
                        $q->where('appointment_id', 'like', "%{$keyword}%")
                          ->orWhere('invoice_date', 'like', "%{$keyword}%")
                          ->orWhere('due_date', 'like', "%{$keyword}%")
                          ->orWhere('refund_date', 'like', "%{$keyword}%")
                          ->orWhere('payment_status', 'like', "%{$keyword}%")
                          ->orWhereHas('patient.user', function ($qq) use ($keyword) {
                              $qq->where('name', 'like', "%{$keyword}%");
                          });
                    });
                    break;
            }
        }

        $invoices = $invoices->orderBy('id', 'asc')->paginate(50);
        $view = view('Backend.employees.accountants.invoices.search', compact('invoices' , 'statusFilter'))->render();
        $pagination = ($invoices->total() > $invoices->perPage()) ? $invoices->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $invoices->total(),
            'searching'  => $keyword !== '',
            'header'     => $header,
        ]);

    }






    public function detailsInvoice($id){
        $invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.details', compact('invoice'));
    }





    public function editInvoice($id){
        $invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.edit', compact('invoice'));
    }


    public function updateInvoice(Request $request , $id){
        $invoice = Invoice::findOrFail($id);

        $total = $request->total_amount;
        $paid  = $request->paid_amount;

        if ($paid > $total) {
            return response()->json(['data' => 0]);
        }

        if ($paid == 0) {
            $payment_status = 'Unpaid';
        } elseif ($paid == $total) {
            $payment_status = 'Paid';
        } else {
            $payment_status = 'Partially Paid';
        }

        $invoice->update([
            'total_amount'  => $request->total_amount,
            'paid_amount'   => $request->paid_amount,
            'invoice_date'  => $request->invoice_date,
            'due_date'      => $request->due_date,
            'payment_method' => $request->payment_method,
            'payment_status' => $payment_status
        ]);

        return response()->json(['data' => 1]);
    }





    public function invoicePDF($id){
        $invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.invoice_pdf' , compact('invoice'));
    }


    public function invoicePDFRaw($id){
        $invoice = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);

        $pdf = PDF::loadView('Backend.employees.accountants.invoices.invoice_pdf_raw', compact('invoice'))->setPaper('A4', 'portrait');

        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }





    public function detailsRefundInvoice($id){
        $refund_invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.cancelled.details', compact('refund_invoice'));
    }





    public function refundConfirmation($id){
        $invoice = Invoice::with([
            'patient.user'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.cancelled.confirmation', compact('invoice'));
    }


    public function updateRefundConfirmation(Request $request , $id){
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'refund_date' => $request->refund_date,
            'refunded_by' => Auth::user()->employee->id,
        ]);

        return response()->json(['data' => 1]);
    }





    public function cancelledinvoicePDF($id){
        $refund_invoice = Invoice::with([
            'patient.user',
            'appointment.clinicDepartment.clinic'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.invoices.Cancelled.invoice_pdf' , compact('refund_invoice'));
    }


    public function cancelledinvoicePDFRaw($id){
        $refund_invoice  = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);

        $pdf = PDF::loadView('Backend.employees.accountants.invoices.Cancelled.invoice_pdf_raw', compact('refund_invoice'))->setPaper('A4', 'portrait');

        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }
}
