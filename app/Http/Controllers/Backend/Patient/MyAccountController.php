<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Patient;

class MyAccountController extends Controller
{
    public function myAccount()
    {
        $clinics = Clinic::all();
        $departments = Department::all();
        $doctors = Doctor::all();
        $patients = Patient::all();
        $admin = User::where('role', 'admin')->first();
        return view('Backend.patients.my_account', compact('clinics', 'departments', 'doctors', 'patients', 'admin'));
    }
}
