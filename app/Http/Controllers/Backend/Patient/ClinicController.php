<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class ClinicController extends Controller
{
    public function clinicsView(Request $request)
    {
        $clinics = Clinic::with('departments')
            ->where('status', 'active')

            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })

            ->when($request->department, function ($q) use ($request) {
                $q->whereHas('departments', function ($subQuery) use ($request) {
                    $subQuery->where('departments.id', $request->department)->where('clinic_departments.status', 'active');
                });
            })
            ->get();

        $departments = Department::where('status', 'active')->get();

        return view('Backend.patients.clinics.view', compact('clinics', 'departments'));
    }
}
