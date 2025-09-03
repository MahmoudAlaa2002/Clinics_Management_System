<?php

namespace App\Http\Controllers\Backend\Admin\Finance;

use App\Models\Patient;
use App\Models\Payment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Http\Controllers\Controller;

class PaymentController extends Controller{

    public function viewPayments(){
        $payments = Payment::with(['invoice'])->orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.patientPayment.view' , compact('payments'));
    }





    public function detailsPayment($id){
        $payment = Payment::with(['invoice', 'paymentDetails'])->findOrFail($id);
        $paymentDetails = $payment->paymentDetails;

        $finalAmount = $payment->invoice->final_amount ?? 0;
        $totalPaid = $paymentDetails->sum('amount_paid');

        return view('Backend.admin.finances.patientPayment.patientsPaymentsDetails.details', compact('paymentDetails', 'finalAmount', 'totalPaid', 'payment'));
    }





    public function editPayment($id){
        $payment = Payment::findOrFail($id);
        $patients = Patient::all();
        return view('Backend.admin.finances.patientPayment.edit' , compact('payment' , 'patients'));
    }


    public function updatePayment(Request $request, $id){
        $payment = Payment::findOrFail($id);
        $exists = Payment::where('id', '!=', $id)->where('invoice_id', $request->invoice_id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'invoice_id'   => $payment->invoice_id,
        ]);

        $payment->update([
            'invoice_id'   => $request->invoice_id,
        ]);

        $payment->refresh();


        $newData = json_encode([
            'invoice_id'   => $payment->invoice_id,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Payments',
            'description' => 'The Patient Payment With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deletePayment(Request $request , $id){
        $payment = Payment::findOrFail($id);
        $invoice = $payment->invoice;

        $oldData = json_encode([
            'invoice_id'   => $payment->invoice_id,
            'patient_id'     => $payment->patient_id,
            'final_amount'  => $invoice->final_amount,
        ]);

        $payment->delete();
        $payment->paymentDetails()->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Payment',
            'description' => 'The patient payment with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'payment deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }





    //Patients Payments Details

    public function editPaymentDetails($id){
        $paymentDetail = PaymentDetail::findOrFail($id);
        return view('Backend.admin.finances.patientPayment.patientsPaymentsDetails.edit' , compact('paymentDetail'));
    }


    public function updatePaymentDetails(Request $request, $id){
        $paymentDetail = PaymentDetail::findOrFail($id);


        $oldData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        $paymentDetail->update([
            'amount_paid'   => $request->amount_paid,
            'payment_method'     => $request->payment_method,
            'payment_date'  => $request->payment_date,
            'notes'  => $request->notes,
        ]);

        $paymentDetail->refresh();



        $newData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Payments Details',
            'description' => 'The patient payment Details with ID '. $id . ' has been Edited by the admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deletePaymentDetails(Request $request , $id){
        $paymentDetail = PaymentDetail::findOrFail($id);

        $oldData = json_encode([
            'amount_paid'   => $paymentDetail->amount_paid,
            'payment_method'     => $paymentDetail->payment_method,
            'payment_date'  => $paymentDetail->payment_date,
            'notes'  => $paymentDetail->notes,
        ]);

        $paymentDetail->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Payment Details',
            'description' => 'The Patient Payment Details with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Patient payment Details deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }
}
