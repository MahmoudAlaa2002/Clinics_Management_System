<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller{

    public function viewReports(){
        // $reports = Report::orderBy('id', 'asc')->paginate(12);
        return view('Backend.admin.reports.view');
    }
}
