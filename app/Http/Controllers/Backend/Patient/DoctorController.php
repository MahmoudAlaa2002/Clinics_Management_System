<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller {

    public function doctorsView(){
        $doctors = Doctor::with([
            'employee.user'
        ])->get();
        return view ('Backend.patients.doctors.view' , compact('doctors'));
    }
}
