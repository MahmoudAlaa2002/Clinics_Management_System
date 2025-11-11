<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicalRecordRequest;

class AppointmentController extends Controller
{
    public function allAppointments(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $appointments = Appointment::with(['patient.user', 'clinic', 'department'])->where('doctor_id', $doctor->id);

        if ($request->has('date') && !empty($request->date)) {
            if ($request->date == 'today') {
                $appointments->where('date', date('Y-m-d'));
            }
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $appointments->where('date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $appointments->where('date', '<=', $request->to_date);
        }

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $appointments->where(function ($query) use ($keyword) {
                $query->where('status', 'ILIKE', "%$keyword%")
                    ->orWhere('date', 'ILIKE', "%$keyword%")
                    ->orWhere('time', 'ILIKE', "%$keyword%")
                    ->orWhereHas('patient.user', function ($q) use ($keyword) {
                        $q->where('name', 'ILIKE', "%$keyword%");
                    });
            });
        }

        return view('Backend.doctors.appointments.index', [
            'appointments' => $appointments->orderBy('date', 'desc')->orderBy('time', 'desc')->paginate(20),
        ]);
    }

    public function show(Appointment $appointment)
    {
        return view('Backend.doctors.appointments.show', compact('appointment'));
    }

    public function confirmAppointment(Appointment $appointment)
    {
        $appointment->status = 'Accepted';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment confirmed successfully.');
    }

    public function rejectAppointment(Appointment $appointment)
    {
        $appointment->status = 'Rejected';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment rejected successfully.');
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use($appointment, $validated){
            $note = $validated['note'] ?? 'Appointment cancelled by doctor';
            $appointment->medicalRecord()->create([
                'appointment_id' => $appointment->id,
                'doctor_id' => Auth::user()->employee->doctor->id,
                'patient_id' => $appointment->patient_id,
                'record_date' => now()->format('Y-m-d'),
                'notes' => $note,
            ]);

            $appointment->status = 'Cancelled';
            $appointment->save();
        });

        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }
}
