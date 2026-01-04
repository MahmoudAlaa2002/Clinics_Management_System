<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use Illuminate\Http\Request;
use App\Models\ClinicDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller{

    public function depratmentProfile(){
        $employee = Auth::user()->employee;
        $clinic   = $employee->clinic;

        $clinicDepartment = ClinicDepartment::with('department')
            ->where('clinic_id', $employee->clinic_id)
            ->where('department_id', $employee->department_id)
            ->firstOrFail();

        $departmentCreatedAt = $clinicDepartment->created_at->toDateString();

        return view('Backend.departments_managers.department.profile',compact(
            'clinic',
            'clinicDepartment',
            'departmentCreatedAt'
        ));
    }




    public function editDepratmentProfile(){
        $employee = Auth::user()->employee;
        $clinicDepartment = ClinicDepartment::with('department')
            ->where('clinic_id', $employee->clinic_id)
            ->where('department_id', $employee->department_id)
            ->firstOrFail();

        return view('Backend.departments_managers.department.editProfile',compact('clinicDepartment')
        );
    }




    public function updateDepratmentProfile(Request $request){
        $employee = Auth::user()->employee;

        $clinicDepartment = ClinicDepartment::with('department')
            ->where('clinic_id', $employee->clinic_id)
            ->where('department_id', $employee->department_id)
            ->firstOrFail();

        if ($clinicDepartment->department->status !== 'active' && $request->status === 'active') {  // لا يمكن نعديل القسم طالما القسم العام غير فعال
            return response()->json(['data' => 0]);
        }

        $clinicDepartment->update([
            'description'   => $request->description,
            'status'        => $request->status,

        ]);
        return response()->json(['data' => 1]);
    }
}
