<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller{

    public function viewDepartments(){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;
        $departments = $clinic->departments;
        return view('Backend.clinics_managers.departments.view', compact('departments'));
    }




    public function addDepartmentToClinic(){
        $departments = Department::all();
        return view('Backend.clinics_managers.departments.add' , compact('departments'));
    }


    public function storeDepartmentToClinic(Request $request){
        $clinicManager = Auth::user();
        $clinic = $clinicManager->employee->clinic;

        $exists = $clinic->departments()->where('departments.id', $request->department_id)->exists();
        if ($exists) {
            return response()->json(['data' => 0]);
        }

        $clinic->departments()->attach($request->department_id);
        return response()->json(['data' => 1]);
    }




    public function detailsDepartment($id){
        $clinic = Auth::user()->employee->clinic;
        $department = $clinic->departments()->where('departments.id', $id)->first();

        // يحضر الدكاترة الموجودين في هادا القسم وفي العيادة المحددة
        $doctors = $department->doctors()->whereHas('employee', function ($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->with('employee.user')->get();
        return view('Backend.clinics_managers.departments.details', compact('department' , 'doctors'));
    }





    public function deleteDepartment($id){
        $clinic = Auth::user()->employee->clinic;
        $department = $clinic->departments()->where('departments.id', $id)->first();
        $clinic->departments()->detach($department->id);
        return response()->json(['data' => 1]);
    }

}
