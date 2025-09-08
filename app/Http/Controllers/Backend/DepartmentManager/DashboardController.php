<?php

namespace App\Http\Controllers\Backend\DepartmentManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller{

    public function departmentManagerDashboard(){
        return view ('Backend.departments_managers.dashboard');
    }
}
