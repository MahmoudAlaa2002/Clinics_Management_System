<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyAccountController extends Controller {

    public function index(){
        $departments = Department::all();
        $doctors = Doctor::all();
        $admin = User::where('role', 'admin')->first();
        return view ('Backend.patients.my_account.index' , compact(
            'departments',
             'doctors',
            'admin',
            ));
    }





    public function clinicsView(){
        $clinics = Clinic::all();
        return view ('Backend.patients.my_account.clinics' , compact('clinics'));
    }




    public function doctorsView(){
        $doctors = Doctor::all();
        return view ('Backend.patients.my_account.doctors' , compact('doctors'));
    }
}
