<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MedicalRecordsController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::user()->employee->doctor->id;

        $medicalRecords = MedicalRecord::with(['patient.user', 'doctor', 'appointment'])
            ->where('doctor_id', $doctorId);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $medicalRecords->where(function($query) use ($search) {
                $query->where('diagnosis', 'ilike', "%{$search}%")
                    ->orWhere('treatment', 'ilike', "%{$search}%")
                    ->orWhere('notes', 'ilike', "%{$search}%")
                    ->orWhereHas('patient.user', function($q) use ($search) {
                        $q->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('from_date')) {
            $medicalRecords->where('record_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $medicalRecords->where('record_date', '<=', $request->to_date);
        }

        $medicalRecords = $medicalRecords->orderBy('record_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('Backend.doctors.medical_records.index', compact('medicalRecords'));
    }

    public function create(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
        ->where('status', 'Accepted')
        ->whereDate('date', '<=', today())
        ->where(function ($query) {
            $query->whereDate('date', '<', today())
                ->orWhere(function ($q) {
                    $q->whereDate('date', today())
                        ->whereTime('time', '<=', now('Asia/Gaza')->format('H:i:s'));
                });
        })
        ->whereDoesntHave('medicalRecord')
        ->with('patient.user')
        ->get();

        return view('Backend.doctors.medical_records.create', compact('appointments'));
    }

    public function store(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
            'prescriptions' => 'nullable|string',
            'attachments' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['doctor_id'] = $doctor->id;
        $validated['record_date'] = now()->format('Y-m-d');

        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Accepted')
            ->whereDate('date', '<=', now())
            ->firstOrFail();

        if ($appointment->medicalRecord) {
            return back()->with('error', 'A medical record already exists for this appointment.');
        }

        DB::transaction(function () use ($appointment, $validated) {

            $appointment->update(['status' => 'Completed']);

            MedicalRecord::create($validated);
        });


        return redirect()->route('doctor.medical_records')->with('success', 'Medical record created successfully.');
    }
}
