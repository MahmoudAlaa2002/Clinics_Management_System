<?php

namespace App\Http\Controllers\Admin;

use App\Models\DosageForm;
use App\Models\Medication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicationController extends Controller{

    public function addMedication(){
        $dosageForms = DosageForm::all();
        return view('Backend.admin.medications.add' , compact('dosageForms'));
    }


    public function storeMedication(Request $request){
        $existingMedication = Medication::where('name', $request->name)->where('dosage_form_id', $request->dosage_form_id)->first();
        if($existingMedication){
            return response()->json(['data' => 0]);
        }else{
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = 'medications/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('medications'), $imageName);
            } else {
                $imageName = null;
            }

            Medication::create([
                'name' => $request->name,
                'dosage_form_id' => $request->dosage_form_id,
                'strength' => $request->strength,
                'image' => $imageName,
                'description' => $request->description,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);
                return response()->json(['data' => 1]);
        }
    }





    public function viewMedications(){
        $medications = Medication::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.medications.view' , compact('medications'));
    }





    public function descriptionMedication($id){
        $medication = Medication::findOrFail($id);
        return view('Backend.admin.medications.description', compact('medication'));
    }





    public function editMedication($id){
        $medication = Medication::findOrFail($id);
        $dosageForms = DosageForm::all();
        return view('Backend.admin.medications.edit', compact('medication' , 'dosageForms'));
    }


    public function updateMedication(Request $request, $id){
        $medication = Medication::findOrFail($id);
        $imageName = $medication->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageFileName = time() . '_' . $file->getClientOriginalName();
            $imagePath = 'medications/' . $imageFileName;
            $file->move(public_path('medications'), $imageFileName);
            $imageName = $imagePath;
        }
            $medication->update([
                'name' => $request->name,
                'dosage_form_id' => $request->dosage_form_id,
                'strength' => $request->strength,
                'description' => $request->description,
                'image' => $imageName,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);
            return response()->json(['data' => 1]);
    }





    public function deleteMedication($id){
        $medication = Medication::findOrFail($id);
        $medication->delete();
        return response()->json(['success' => true]);
    }
}
