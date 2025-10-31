<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller{


    public function viewInvoices(){
        $invoices = Invoice::orderBy('id', 'asc')->paginate(12);
        return view ('Backend.admin.invoices.view' , compact('invoices'));
    }





    public function searchInvoices(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $invoices = Invoice::with(['patient.user', 'appointment']);

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

        $invoices = $invoices->orderBy('id', 'asc')->paginate(12);

        $view = view('Backend.admin.invoices.search', compact('invoices'))->render();
        $pagination = $invoices->total() > 12 ? $invoices->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $invoices->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function detailsInvoice($id){
        $invoice = Invoice::findOrFail($id);
        return view ('Backend.admin.invoices.details' , compact('invoice'));
    }





    public function editInvoice($id){
        $invoice = Invoice::findOrFail($id);
        return view ('Backend.admin.invoices.edit' , compact('invoice'));
    }





    public function updateInvoice(Request $request, $id){
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'total_amount' => $request->total_amount,
            'payment_status' => $request->payment_status,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['data' => 1]);
    }





    public function deleteInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['success' => true]);
    }

}
