<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyAccountController extends Controller {

    public function myAccount(){
        $departments = Department::all();
        $doctors = Doctor::all();
        $admin = User::where('role', 'admin')->first();
        return view ('Backend.patients.my_account' , compact(
            'departments',
             'doctors',
            'admin',
            ));
    }

}
