<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Patient;

class HomeController extends Controller {

    public function home() {
        $clinics = Clinic::all();
        $departments = Department::all();
        $patients = Patient::all();
        $admin = User::where('role', 'admin')->first();
        $doctors_count = Doctor::count();
        $doctors = Doctor::orderBy('rating', 'desc')->take(10)->get();
        return view('Backend.patients.home', compact('clinics', 'departments', 'doctors', 'patients', 'admin', 'doctors_count'));
    }

}
