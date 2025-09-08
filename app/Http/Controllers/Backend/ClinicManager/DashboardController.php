<?php

namespace App\Http\Controllers\Backend\ClinicManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller{

    public function clinicManagerDashboard(){
        return view ('Backend.clinics_managers.dashboard');
    }
}
