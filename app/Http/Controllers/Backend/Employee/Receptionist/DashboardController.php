<?php

namespace App\Http\Controllers\Backend\Employee\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function receptionistDashboard(){
        return view ('Backend.employees.receptionists.dashboard');
    }
}
