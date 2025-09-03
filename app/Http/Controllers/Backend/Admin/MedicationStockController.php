<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use App\Http\Controllers\Controller;

class MedicationStockController extends Controller{

    public function addToStock(){
        $clinics = Clinic::all();
        $medications = Medication::all();
        return view('Backend.admin.stocks.add' , compact('clinics' , 'medications'));
    }


    public function storeToStock(Request $request){
        MedicineStock::create([
            'clinic_id' => $request->clinic_id,
            'medication_id' => $request->medication_id,
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }


    public function generateBatchNumber(Request $request){
        $clinic = Clinic::find($request->clinic_id);
        $medication = Medication::find($request->medication_id);

        if (!$clinic || !$medication) {
            return response()->json(['batch_number' => null]);
        }


        $prefix = strtoupper(substr($clinic->name, 0, 2)) . strtoupper(substr($medication->name, 0, 2));  // أول حرفين من العيادة وأول حرفين من الدواء

        $year = Carbon::now()->year;

        $count = MedicineStock::where('clinic_id', $clinic->id)->where('medication_id', $medication->id)->count() + 1;   // رقم تسلسلي: عدد الدفعات الموجودة مسبقًا + 1

        $batchNumber = $prefix . $year . '-' . $count;

        return response()->json(['batch_number' => $batchNumber]);
    }





    public function viewStocks(){
        $medicineStocks = MedicineStock::orderBy('id', 'asc')->paginate(10);
        return view('Backend.admin.stocks.view' , compact('medicineStocks'));
    }





    public function descriptionStock($id){
        $stock = MedicineStock::findOrFail($id);
        return view('Backend.admin.stocks.description', compact('stock'));
    }





    public function editStock($id){
        $medicineStocks = MedicineStock::findOrFail($id);
        $medications = Medication::all();
        $clinics = Clinic::all();
        return view('Backend.admin.stocks.edit', compact('medicineStocks' , 'clinics' , 'medications'));
    }


    public function updateStock(Request $request, $id){
        $medicineStock = MedicineStock::findOrFail($id);
        $medicineStock->update([
            'clinic_id' => $request->clinic_id,
            'medication_id' => $request->medication_id,
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return response()->json(['data' => 1]);
    }





    public function deleteStock($id){
        $medicineStocks = MedicineStock::findOrFail($id);
        $medicineStocks->delete();
        return response()->json(['success' => true]);
    }
}
