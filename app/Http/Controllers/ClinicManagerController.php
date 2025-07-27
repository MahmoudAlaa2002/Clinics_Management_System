<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClinicManagerController extends Controller{
    
    public function clinicManagerDashboard(){
        return view('Backend.clinic_managers.dashboard');
    }
}
