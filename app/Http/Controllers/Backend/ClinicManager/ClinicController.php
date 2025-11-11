<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Clinic;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller{

    public function clinicProfile(){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;
        return view('Backend.clinics_managers.clinics.profile' , compact('clinic'));
    }




    public function editClinicProfile(){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;
        $working_days = $clinic->working_days ;
        $all_departments = Department::all();
        $clinic_departments = $clinic->departments->pluck('id')->toArray();
        return view('Backend.clinics_managers.clinics.edit' , compact('clinic' ,
        'working_days',
        'all_departments',
        'clinic_departments',
        ));
    }


    public function updateClinicProfile(Request $request){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;

        $normalizedName = strtolower(trim($request->name));
        $normalizedEmail = strtolower(trim($request->email));

        $exists = Clinic::where(function ($query) use ($normalizedName, $normalizedEmail) {
                $query->whereRaw('LOWER(name) = ?', [$normalizedName])
                      ->orWhereRaw('LOWER(email) = ?', [$normalizedEmail]);
            })->where('id', '!=', $clinic->id)->exists();

        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $clinic->update([
            'name'          => $request->name,
            'location'      => $request->location,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'opening_time'  => $request->opening_time,
            'closing_time'  => $request->closing_time,
            'description'   => $request->description,
            'status'        => $request->status,
            'working_days'  => $request->working_days,
        ]);

        $clinic->departments()->sync($request->input('departments', []));
        return response()->json(['data' => 1]);
    }
}
