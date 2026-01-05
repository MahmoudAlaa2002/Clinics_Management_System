<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DoctorController extends Controller
{
    public function doctorsView(Request $request)
    {
        $doctors = Doctor::with(['employee.user', 'employee.department'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('employee.user', function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->specialtie, function ($q) use ($request) {
                $q->whereHas('employee.department', function ($sub) use ($request) {
                    $sub->where('name', $request->specialtie);
                });
            })
            ->get();

        $specialties = Doctor::select('speciality')->whereNotNull('speciality')->distinct()->pluck('speciality');
        return view('Backend.patients.doctors.view', compact('doctors', 'specialties'));
    }
}
