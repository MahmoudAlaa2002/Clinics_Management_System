<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller{

    public function depratmentProfile(){
        $clinic = Auth::user()->employee->clinic;
        $department = Auth::user()->employee->department;
        $created_at = ClinicDepartment::where('clinic_id', $clinic->id)->where('department_id', $department->id)->value('created_at');
        $departmentCreatedAt = \Carbon\Carbon::parse($created_at)->toDateString();
        return view('Backend.departments_managers.department.profile' , compact('clinic' , 'department' , 'departmentCreatedAt'));
    }




    public function editDepratmentProfile(){
        $department = Auth::user()->employee->department;
        return view('Backend.departments_managers.department.editProfile' , compact('department'));
    }



    public function updateDepratmentProfile(Request $request){
        $department = Auth::user()->employee->department;
        $department->update([
            'description'   => $request->description,
            'status'        => $request->status,

        ]);
        return response()->json(['data' => 1]);
    }
}
