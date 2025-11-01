<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->employee->doctor;
        $patients = $doctor->patients()->distinct()->with('user');

        if (request()->has('keyword') && !empty(request()->keyword)) {
            $keyword = request()->keyword;
            $patients->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'ILIKE', "%$keyword%")
                  ->orWhere('email', 'ILIKE', "%$keyword%")
                  ->orWhere('phone', 'ILIKE', "%$keyword%")
                  ->orWhere('blood_type', 'ILIKE', "%$keyword%");
            });
        }
        $patients = $patients->paginate(10);

        return view('Backend.doctors.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load('user');

        return view('Backend.doctors.patients.show', compact('patient'));
    }
}
