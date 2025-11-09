<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clinic;

class ClinicController extends Controller
{
    public function show(Clinic $clinic)
    {
        $clinic->with(['departments', 'doctors.employee.user']);

        $doctors = $clinic->employees
            ->filter(fn($emp) => $emp->doctor !== null)
            ->map(fn($emp) => $emp->doctor);

        return view('Backend.doctors.clinics.show', compact('clinic', 'doctors'));
    }
}
