<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;


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

        return view('Backend.employees.nurses.department.profile',compact(
            'clinic',
            'clinicDepartment',
            'departmentCreatedAt'
        ));
    }
}
