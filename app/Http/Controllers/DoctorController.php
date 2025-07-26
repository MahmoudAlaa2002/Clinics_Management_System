<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class DoctorController extends Controller{

    public function getSpecialtiesByClinic($clinic_id){
        // جلب التخصصات المرتبطة بالعيادة
        $specialties = Clinic::find($clinic_id)->specialties;

        return response()->json($specialties);
    }


    public function getClinicInfo($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json([
            'opening_time' => $clinic->opening_time,
            'closing_time' => $clinic->closing_time,
        ]);
    }


    public function getWorkingDays($id){
        $clinic = Clinic::findOrFail($id);
        return response()->json($clinic->working_days);
    }
}
