<?php

namespace App\Http\Controllers\Backend\shared;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonDoctorController extends Controller{

    public function getDoctorsByClinicAndDepartment(Request $request){
        $doctors = Doctor::whereHas('employee', function ($q) use ($request) {
            $q->where('clinic_id', $request->clinic_id)
              ->where('department_id', $request->department_id);
        })->with(['employee.user:id,name'])->get()
        ->map(fn($d) => [
            'id'   => $d->id,
            'name' => optional(optional($d->employee)->user)->name ?? 'Unknown'
        ])->values();

        return response()->json($doctors);
    }





    public function getDoctorInfo($id){
        $doctor = Doctor::with('employee')->findOrFail($id);
        return response()->json([
            'work_start_time' => $doctor->employee?->work_start_time,
            'work_end_time'   => $doctor->employee?->work_end_time,
        ]);
    }


    public function getWorkingDays($id){
        $doctor = Doctor::with('employee')->findOrFail($id);
        $days = $doctor->employee?->working_days ?? [];
        return response()->json($days);
    }
}
