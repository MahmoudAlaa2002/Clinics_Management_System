<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller{

    public function clinicProfile(){
        $clinic = Auth::user()->employee->clinic;
        return view('Backend.departments_managers.clinic.profileView' , compact('clinic'));
    }
}
