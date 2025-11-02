<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->employee->doctor;
        $invoices = Invoice::with('appointment')->whereHas('appointment', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->get();
        dd($invoices);

        return view('backend.doctor.invoices.index', compact('invoices'));
    }
}
