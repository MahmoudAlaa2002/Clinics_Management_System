<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClinicController extends Controller {

    public function clinicsView(){
        $clinics = Clinic::all();
        return view ('Backend.patients.clinics.view' , compact('clinics'));
    }
}
