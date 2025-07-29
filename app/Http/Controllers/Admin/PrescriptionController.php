<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PrescriptionItem;
use App\Http\Controllers\Controller;

class PrescriptionController extends Controller{

    public function viewPrescriptions(){
        $prescriptions = Prescription::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.prescriptions.view' , compact('prescriptions'));
    }


    public function descriptionPrescription($id){
        $prescriptionItems = PrescriptionItem::with('medications.dosageForm')->where('prescription_id', $id)->get();
        return view('Backend.admin.prescriptions.prescription_items', compact('prescriptionItems'));
    }
}
