<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class DashboardController extends Controller {

    public function patientDashboard(){
        return view ('Backend.patients.dashboard');
    }

    public function personalityStatistics()
    {
        $patient = Auth::user()->load('patient')->patient;

        $patientAppointments = Appointment::where('patient_id', $patient->id)->orderBy('date', 'desc')->get();
        $upCamingAppointments = $patientAppointments->where('date', '>=', now()->format('Y-m-d'));
        $completedAppointments = $patientAppointments->where('status', 'Completed')->count();

        $recordsCount = MedicalRecord::wherePatientId($patient->id)->count();

        $patientInvoices = Invoice::wherePatientId($patient->id)->get();
        $totalAmount = $patientInvoices->where('payment_status', 'Paid')->sum('total_amount');
        $totalUnpaidAmount = $patientInvoices->where('payment_status', 'Unpaid')->sum('total_amount');

        return view('Backend.patients.statistics', compact([
            'patientAppointments',
            'upCamingAppointments',
            'completedAppointments',
            'recordsCount',
            'totalAmount',
            'totalUnpaidAmount'
            ]));
    }
}
