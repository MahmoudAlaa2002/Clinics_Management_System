<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function showBookingPage()
    {
        $clinics = Clinic::where('status', 'active')->get();

        return view('Backend.patients.booking', compact('clinics'));
    }

    public function bookAppointment(Request $request, $id)
    {
        $doctor = Doctor::with(['employee.clinic.departments'])->find($id);
        dd($doctor->clinic_department_id);
        if (!$doctor) {
            return redirect()->back()->withErrors(['error' => 'Doctor not found.']);
        }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'note' => 'nullable|string',
        ]);

        $appointment = $doctor->appointments()->create([
            'doctor_id' => $id,
            'patient_id' => Auth::user()->id,
            'clinic_department_id' => $doctor->clinic_department_id,
            'appointment_date' => $validatedData['date'],
            'appointment_time' => $validatedData['time'],
            'note' => $validatedData['note'] ?? null,
            'status' => 'pending_payment',
        ]);

        return redirect()->route('patient.payment.confirm', ['appointment' => $appointment->id])
            ->with('info', 'Please proceed with payment to confirm your appointment.');
        }
    }
