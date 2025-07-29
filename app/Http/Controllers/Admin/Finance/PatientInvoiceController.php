<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Models\Patient;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\PatientInvoice;
use App\Http\Controllers\Controller;

class PatientInvoiceController extends Controller{

    public function viewInvoices(){
        $patientInvoices = PatientInvoice::with('clinic')->orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.patientInvoice.view' , compact('patientInvoices'));
    }





    public function detailsInvoice($id){
        $patientInvoice = PatientInvoice::with(['patient', 'items'])->findOrFail($id);
        return view('Backend.admin.finances.patientInvoice.details' , compact('patientInvoice'));
    }





    public function editInvoice($id){
        $patientInvoice = PatientInvoice::findOrFail($id);
        $patients = Patient::all();
        return view('Backend.admin.finances.patientInvoice.edit' , compact('patientInvoice' , 'patients'));
    }


    public function updateInvoice(Request $request, $id){
        $patientInvoice = PatientInvoice::findOrFail($id);

        // $finalAmount = (float) $request->total_amount - (float) $request->discount;

        $exists = PatientInvoice::where('id', '!=', $id)
            ->where('appointment_id', $request->appointment_id)
            // ->where('total_amount', $request->total_amount)
            ->where('discount', $request->discount)
            // ->where('final_amount', $finalAmount)
            ->where('status', $request->status)
            ->where('notes', $request->notes)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);

        $patientInvoice->update([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'discount' => $request->discount,
            // 'final_amount' => $finalAmount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $patientInvoice->refresh();

        $newData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Patient Invoices',
            'description' => 'The patient invoice with ID '. $id . ' has been Edited by the admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteInvoice(Request $request , $id){
        $patientInvoice = PatientInvoice::findOrFail($id);
        $oldData = json_encode([
            'appointment_id' => $patientInvoice->appointment_id,
            'patient_id'     => $patientInvoice->patient_id,
            'total_amount'   => $patientInvoice->total_amount,
            'discount'       => $patientInvoice->discount,
            'final_amount'   => $patientInvoice->final_amount,
            'status'         => $patientInvoice->status,
            'notes'          => $patientInvoice->notes,
        ]);
        $patientInvoice->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Patient Invoices',
            'description' => 'The patient invoice with ID '. $id . ' has been deleted by the admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Invoice deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }
}
