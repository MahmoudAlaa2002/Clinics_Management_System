<?php

namespace App\Http\Controllers\Backend\Employee\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller{

    public function nurseDashboard(){
        return view ('Backend.employees.nurses.dashboard');
    }
}
