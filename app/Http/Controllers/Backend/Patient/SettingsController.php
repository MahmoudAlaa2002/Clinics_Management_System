<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller {

    public function settings(){
        $patient = auth()->user();
        return view('Backend.patients.settings.view' , compact('patient'));
    }



    public function support(){
        $patient = auth()->user();
        $admin = User::role('admin')->first();
        return view('Backend.patients.settings.support' , compact('patient' , 'admin'));
    }
}
