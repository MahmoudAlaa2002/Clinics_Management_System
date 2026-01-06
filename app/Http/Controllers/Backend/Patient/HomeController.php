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
        $doctors = Doctor::whereNotNull('rating')->orderByDesc('rating')->orderByDesc('created_at')->take(4)->get();
        return view('Backend.patients.home', compact('clinics', 'departments', 'doctors', 'patients', 'admin'));
    }

}
