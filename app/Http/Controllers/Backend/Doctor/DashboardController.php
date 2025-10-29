<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function doctorDashboard(){
        return view ('Backend.doctors.dashboard');
    }
}
