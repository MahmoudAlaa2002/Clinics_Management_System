<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller{

    public function clinicProfile(){
        $clinic = Auth::user()->employee->clinic;
        return view('Backend.employees.nurses.clinic.profile' , compact('clinic'));
    }
}
