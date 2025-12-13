<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller{
    
    public function clinicProfile(){
        $clinic = Auth::user()->employee->clinic;
        return view('Backend.employees.accountants.clinic.profile' , compact('clinic'));
    }
}
