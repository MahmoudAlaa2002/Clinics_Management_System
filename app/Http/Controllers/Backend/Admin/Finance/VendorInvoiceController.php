<?php

namespace App\Http\Controllers\Backend\Admin\Finance;

use App\Models\Clinic;
use App\Models\Vendor;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\VendorInvoice;
use App\Http\Controllers\Controller;

class VendorInvoiceController extends Controller{

    public function viewVendorInvoices(){
        $vendorInvoices = VendorInvoice::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.finances.vendorInvoice.view' , compact('vendorInvoices'));
    }





    public function detailsVendorInvoice($id){
        $vendorInvoices = VendorInvoice::with(['vendor' , 'items'])->findOrFail($id);
        return view('Backend.admin.finances.vendorInvoice.details' , compact('vendorInvoices'));
    }





    public function editVendorInvoice($id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $vendors = Vendor::all();
        $clinics = Clinic::all();
        return view('Backend.admin.finances.vendorInvoice.edit' , compact('vendorInvoice','vendors','clinics'));
    }


    public function updateVendorInvoice(Request $request, $id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $finalAmount = (float) $request->total_amount - (float) $request->discount;

        $exists = VendorInvoice::where('id', '!=', $id)
            ->where('vendor_id', $request->vendor_id)
            ->where('clinic_id', $request->clinic_id)
            ->where('invoice_date', $request->invoice_date)
            ->where('final_amount', $request->final_amount)
            ->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $oldData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);

        $vendorInvoice->update([
            'vendor_id' => $request->vendor_id,
            'clinic_id' => $request->clinic_id,
            'invoice_date' => $request->invoice_date,
            'total_amount' => $request->total_amount,
            'discount' => $request->discount,
            'final_amount' => $finalAmount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $vendorInvoice->refresh();

        $newData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Edit',
            'module' => 'Vendor Invoices',
            'description' => 'The Vendor Invoice With ID '. $id . ' Has Been Edited By The Admin',
            'old_data' => $oldData,
            'new_data'    => $newData,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['data' => 1]);
    }






    public function deleteVendorInvoice(Request $request , $id){
        $vendorInvoice = VendorInvoice::findOrFail($id);
        $oldData = json_encode([
            'vendor_id' => $vendorInvoice->vendor_id,
            'clinic_id' => $vendorInvoice->clinic_id,
            'invoice_date' => $vendorInvoice->invoice_date,
            'total_amount' => $vendorInvoice->total_amount,
            'discount' => $vendorInvoice->discount,
            'final_amount' => $vendorInvoice->final_amount,
            'status' => $vendorInvoice->status,
            'notes' => $vendorInvoice->notes,
        ]);
        $vendorInvoice->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'module' => 'Vendor Invoices',
            'description' => 'The Vendor Invoice With ID '. $id . ' Has Been Deleted By The Admin',
            'old_data' => $oldData,
            'new_data'    => json_encode(['message' => 'Vendor Invoice deleted']),
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['success' => true]);
    }
}
