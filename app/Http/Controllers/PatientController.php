<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller{

    public function getSpecialtiesByClinic($clinic_id){
        $clinic = Clinic::with('specialties')->findOrFail($clinic_id);
        return response()->json($clinic->specialties);
    }


    public function getDoctorsByClinicAndSpecialty(Request $request){
        $clinicId = $request->clinic_id;
        $specialtyId = $request->specialty_id;

        $doctors = Doctor::where('clinic_id', $clinicId)
                        ->where('specialty_id', $specialtyId)
                        ->get();

        return response()->json($doctors);
    }


    public function getDoctorInfo($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json([
            'work_start_time' => $doctor->work_start_time,
            'work_end_time'   => $doctor->work_end_time,
        ]);
    }


    public function getWorkingDays($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json(
            is_string($doctor->working_days)
                ? json_decode($doctor->working_days)
                : $doctor->working_days
        );
    }
}
