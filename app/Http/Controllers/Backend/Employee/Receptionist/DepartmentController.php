<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

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
        return view('Backend.employees.receptionists.department.profile' , compact('clinic' , 'department' , 'departmentCreatedAt'));
    }

}
