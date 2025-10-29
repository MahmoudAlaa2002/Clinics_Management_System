<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function allAppointments()
    {
        $doctor = Auth::user()->employee->doctor;
        dd($doctor);
        return view('Backend.doctors.appointments.index');
    }
}
