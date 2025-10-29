<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function patientDashboard(){
        return view ('Backend.patients.dashboard');
    }
}
