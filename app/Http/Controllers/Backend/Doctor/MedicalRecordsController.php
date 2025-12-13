<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                $query->where('diagnosis', 'like', "%{$search}%")
                    ->orWhere('treatment', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('patient.user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
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
            'diagnosis' => 'nullable|string|max:1000',
            'other_diagnosis' => 'nullable|string|max:1000',
            'treatment' => 'nullable|string|max:1000',
            'prescriptions' => 'nullable|string|max:1000',
            'attachmentss.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['doctor_id'] = $doctor->id;
        $validated['record_date'] = now()->format('Y-m-d');

        if ($request->diagnosis === 'Other') {
            $validated['diagnosis'] = $request->other_diagnosis;
        }

        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Accepted')
            ->whereDate('date', '<=', now())
            ->firstOrFail();

        if ($appointment->medicalRecord) {
            return back()->with('error', 'A medical record already exists for this appointment.');
        }

        try {
            DB::beginTransaction();

            $uploadedFiles = [];
            if ($request->hasFile('attachmentss')) {
                foreach ($request->file('attachmentss') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('medical_records', $originalName, 'public');
                    $uploadedFiles[] = $path;
                }
                $validated['attachmentss'] = json_encode($uploadedFiles);
            }

            $appointment->update(['status' => 'Completed']);

            MedicalRecord::create($validated);

            DB::commit();

            return redirect()
                ->route('doctor.medical_records')
                ->with('success', 'Medical record created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function show(MedicalRecord $medicalRecord)
    {
        return view('Backend.doctors.medical_records.show', compact('medicalRecord'));
    }

    public function edit(Request $request, MedicalRecord $medicalRecord)
    {
        return view('Backend.doctors.medical_records.edit', compact('medicalRecord'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'diagnosis' => 'nullable|string|max:1000',
            'other_diagnosis' => 'nullable|string|max:1000',
            'treatment' => 'nullable|string|max:1000',
            'record_date' => 'required|date',
            'prescriptions' => 'nullable|string|max:1000',
            'attachmentss.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->diagnosis === 'Other') {
            $validated['diagnosis'] = $request->other_diagnosis;
        }

        try {
            DB::beginTransaction();

            $oldFiles = $medicalRecord->attachmentss ? json_decode($medicalRecord->attachmentss, true) : [];

            if ($request->has('remove_files')) {
                foreach ($request->remove_files as $fileToRemove) {
                    Storage::disk('public')->delete($fileToRemove);
                    $oldFiles = array_filter($oldFiles, fn($f) => $f !== $fileToRemove);
                }
            }

            if ($request->hasFile('attachmentss')) {
                $newFiles = [];
                foreach ($request->file('attachmentss') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('medical_records', $originalName, 'public');
                    $newFiles[] = $path;
                }

                $oldFiles = array_merge($oldFiles, $newFiles);
            }

            $validated['attachmentss'] = json_encode(array_values($oldFiles));

            $medicalRecord->update($validated);

            DB::commit();

            return redirect()
                ->route('doctor.medical_records.show', $medicalRecord)
                ->with('success', 'Medical Record updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating the record.');
        }
    }


    public function patientRecords(Patient $patient)
    {
        $records = MedicalRecord::with(['doctor.employee.user', 'patient.user'])
                    ->where('patient_id', $patient->id)
                    ->orderBy('record_date', 'desc')
                    ->get();

        return view('Backend.doctors.patients.medical-records', compact('records', 'patient'));
    }
}
