<?php

namespace App\Http\Controllers\Backend\Shared;

use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonClinicController extends Controller{

    public function getDepartmentsByClinic($clinic_id){
        $clinic = Clinic::with('departments')->find($clinic_id);
        if (!$clinic) {
            return response()->json([]);
        }
        return response()->json($clinic->departments);
    }



    public function getClinicInfo($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'opening_time' => $clinic->opening_time,
            'closing_time' => $clinic->closing_time,
        ]);
    }


    public function getWorkingDays($id) {
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'working_days' => $clinic->working_days,
        ]);
    }
}
