<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use App\Models\VitalSign;
use App\Models\ActivityLog;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VitalSignsController extends Controller{

    public function addVitalSigns($appointment_id){
        $appointment = Appointment::with(['patient.user','doctor.employee.user'])->findOrFail($appointment_id);
        return view('Backend.employees.nurses.vital_signs.add' , compact('appointment'));
    }


    public function storeVitalSigns(Request $request){
        $vitalSigns = VitalSign::create([
            'appointment_id' => $request->appointment_id,
            'nurse_id' => Auth::user()->employee->id,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'temperature' => $request->temperature,
            'oxygen_saturation' => $request->oxygen_saturation,
            'blood_sugar' => $request->blood_sugar,
            'notes' => $request->notes,
        ]);

        return response()->json(['data' => 1]);
    }






    public function viewVitalSigns($id){
        $vitalSigns = VitalSign::where('appointment_id', $id)->first();
        return view('Backend.employees.nurses.vital_signs.view' , compact('vitalSigns'));
    }





    public function editVitalSigns($id){
        $vitalSigns = VitalSign::find($id);
        return view('Backend.employees.nurses.vital_signs.edit', compact('vitalSigns'));
    }


    public function updateVitalSigns(Request $request, $id){
        $vitalSigns = VitalSign::find($id);

        $oldData = $vitalSigns->toArray();   // حفظ نسخة من البيانات القديمة قبل التعديل

        $vitalSigns->update([
            'nurse_id' => Auth::user()->employee->id,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'temperature' => $request->temperature,
            'oxygen_saturation' => $request->oxygen_saturation,
            'blood_sugar' => $request->blood_sugar,
            'notes' => $request->notes,
        ]);


        $newData = $vitalSigns->fresh()->toArray();   // حفظ البيانات بعد التعديل

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'target_table' => 'vital_signs',
            'old_data' => json_encode($oldData, JSON_UNESCAPED_UNICODE),
            'new_data' => json_encode($newData, JSON_UNESCAPED_UNICODE),
            'ip_address' => request()->ip(),
            'details' => 'Updated vital signs for appointment ID: ' . $vitalSigns->appointment_id,
        ]);

        return response()->json(['data' => 1]);
    }




}
