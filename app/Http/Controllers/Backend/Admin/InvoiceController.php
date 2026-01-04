<?php

namespace App\Http\Controllers\Backend\Admin;

use PDF;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller{


    public function viewInvoices(Request $request){
        $statusFilter = $request->input('invoiceFilter', 'Issued');

        $invoices = Invoice::with(['patient.user', 'appointment'])
            ->when($statusFilter, function ($query) use ($statusFilter) {
                return $query->where('invoice_status', $statusFilter);
            })->orderBy('id', 'asc')->paginate(50);

        return view ('Backend.admin.invoices.view' , compact('invoices' , 'statusFilter'));
    }




    public function searchInvoices(Request $request){
        $keyword       = trim($request->input('keyword', ''));
        $filter        = $request->input('filter', '');
        $statusFilter  = $request->input('invoiceFilter', 'Issued');

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

        $invoices = Invoice::with(['patient.user', 'appointment'])
            ->when($statusFilter, function ($query) use ($statusFilter) {
                return $query->where('invoice_status', $statusFilter);
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

                case 'refund_date':
                    $invoices->where('refund_date', 'like', "{$keyword}%");
                    break;

                case 'payment_status':
                    $invoices->where('payment_status', 'like', "{$keyword}%");
                    break;

                default:
                    $invoices->where(function ($q) use ($keyword) {
                        $q->where('appointment_id', 'like', "{$keyword}%")
                          ->orWhere('invoice_date', 'like', "{$keyword}%")
                          ->orWhere('due_date', 'like', "{$keyword}%")
                          ->orWhere('refund_date', 'like', "{$keyword}%")
                          ->orWhere('payment_status', 'like', "{$keyword}%")
                          ->orWhereHas('patient.user', function ($qq) use ($keyword) {
                              $qq->where('name', 'like', "{$keyword}%");
                          });
                    });
                    break;
            }
        }

        $invoices = $invoices->orderBy('id', 'asc')->paginate(50);

        $view = view(
            'Backend.admin.invoices.search',
            compact('invoices', 'statusFilter')
        )->render();

        $pagination = ($invoices->total() > $invoices->perPage())
            ? $invoices->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $invoices->total(),
            'searching'  => $keyword !== '',
            'header'     => $header,
        ]);
    }






    public function detailsInvoice($id){
        $invoice = Invoice::with(['patient.user','appointment'])->findOrFail($id);
        return view ('Backend.admin.invoices.details' , compact('invoice'));
    }





    public function editInvoice($id){
        $invoice = Invoice::with(['patient.user','appointment'])->findOrFail($id);
        return view ('Backend.admin.invoices.edit' , compact('invoice'));
    }





    public function updateInvoice(Request $request , $id){
        $invoice = Invoice::findOrFail($id);

        $total = $request->total_amount;
        $paid  = $request->paid_amount;

        if ($paid > $total) {
            return response()->json(['data' => 0]);   // Check for overpayment
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





    public function detailsRefundInvoice($id){
        $refund_invoice = Invoice::findOrFail($id);
        return view ('Backend.admin.invoices.cancelled.details' , compact('refund_invoice'));
    }





    public function deleteInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['success' => true]);
    }





    public function invoicePDF($id){
        $invoice = Invoice::findOrFail($id);
        return view('Backend.admin.invoices.invoice_pdf' , compact('invoice'));
    }


    public function invoicePDFRaw($id){
        $invoice = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);
        $pdf = PDF::loadView('Backend.admin.invoices.invoice_pdf_raw', compact('invoice'))->setPaper('A4', 'portrait');
        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }





    public function cancelledinvoicePDF($id){
        $refund_invoice = Invoice::findOrFail($id);
        return view('Backend.admin.invoices.cancelled.invoice_pdf' , compact('refund_invoice'));
    }


    public function cancelledinvoicePDFRaw($id){
        $refund_invoice = Invoice::with(['appointment.clinicDepartment.clinic', 'patient.user'])->findOrFail($id);
        $pdf = PDF::loadView('Backend.admin.invoices.cancelled.invoice_pdf_raw', compact('refund_invoice'))->setPaper('A4', 'portrait');
        return response()->json([
            'pdf' => base64_encode($pdf->output())
        ]);
    }




}
