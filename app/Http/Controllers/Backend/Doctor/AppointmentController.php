<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function allAppointments(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id);

        if ($request->has('from')) {
            $appointments = $appointments->whereDate('date', '>=', $request->from);
        }

        if ($request->has('to')) {
            $appointments = $appointments->whereDate('date', '<=', $request->to);
        }

        if ($request->has('status')) {
            $appointments = $appointments->where('status', $request->status);
        }

        return view('Backend.doctors.appointments.index', [
            'appointments' => $appointments->get(),
        ]);
    }

    public function confirmAppointment(Appointment $appointment)
    {
        $appointment->status = 'Accepted';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment confirmed successfully.');
    }
}
