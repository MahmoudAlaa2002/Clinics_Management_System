<?php

namespace App\Http\Controllers\Backend\Patient;

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
            ])->orderBy('invoice_date', 'desc')->get();

        return view('Backend.patients.invoices.view', compact('patient', 'invoices'));
    }




    public function detailsInvoice($id){
        $invoice = Invoice::with([
                'appointment.doctor.employee.user',
                'appointment.clinic'
            ])->findOrFail($id);

        return view('Backend.patients.invoices.details', compact('invoice'));
    }
}
