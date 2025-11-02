<?php

namespace App\Http\Controllers\Backend\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user()->employee->doctor;
        $invoices = Invoice::with('appointment')->whereHas('appointment', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        });

        if ($request->filled('search')) {
            $search = $request->input('search');

            $invoices->where(function($query) use ($search) {
                $query->where('payment_status', 'ilike', "%{$search}%")
                    ->orWhereHas('patient.user', function($q) use ($search) {
                        $q->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        $invoices = $invoices->orderBy('invoice_date', 'desc')->paginate(10)->withQueryString();

        return view('Backend.doctors.invoices.index', compact('invoices'));
    }
}
