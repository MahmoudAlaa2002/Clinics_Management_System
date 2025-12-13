<?php

namespace App\Http\Controllers\Backend\Admin\Report;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class PatientController extends Controller{


    public function patientsReportsView(){
        return view('Backend.admin.reports.patients.patient_report_view');
    }

    public function patientsReportsRaw(){
        $total_patients = Patient::count();
        $total_patients_monthly = Patient::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $monthly = Patient::selectRaw('COUNT(*) as total, MONTH(created_at) as month')->whereYear('created_at', now()->year)->groupBy('month')->get();
        $average_monthly_registrations = $monthly->avg('total');

        $total_patients_male = Patient::whereHas('user', function ($q) {
            $q->where('gender', 'male');
        })->count();
        $total_patients_female = Patient::whereHas('user', function ($q) {
            $q->where('gender', 'female');
        })->count();


        // 0 – 12 years
        $total_patients_children = Patient::whereHas('user', function ($q) {
            $q->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 0 AND 12');
        })->count();

        // 13 – 19 years
        $total_patients_teens = Patient::whereHas('user', function ($q) {
            $q->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 13 AND 19');
        })->count();

        // 20 – 59 years
        $total_patients_adults = Patient::whereHas('user', function ($q) {
            $q->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) BETWEEN 20 AND 59');
        })->count();

        // 60+ years
        $total_patients_seniors = Patient::whereHas('user', function ($q) {
            $q->whereRaw('TIMESTAMPDIFF(YEAR, users.date_of_birth, CURDATE()) >= 60');
        })->count();


        $visitFrequency = $this->visitFrequency();     // استدعاء ميثود كامل
        $commonReasons = $this->commonVisitReasons();
        $paymentInsights = $this->paymentInsights();

        $pdf = PDF::loadView('Backend.admin.reports.patients.patient_pdf', compact(
            'total_patients',
            'total_patients_monthly',
            'average_monthly_registrations',
            'total_patients_male',
            'total_patients_female',
            'total_patients_children',
            'total_patients_teens',
            'total_patients_adults',
            'total_patients_seniors',
            'visitFrequency',
            'commonReasons',
            'paymentInsights',
        ))->setPaper('A4', 'portrait');

        $pdfContent = $pdf->output();

        return response()->json(['pdf' => base64_encode($pdfContent)]);
    }






    public function visitFrequency(){
        $currentYear = now()->year;
        $visits = Appointment::selectRaw('patient_id, COUNT(*) as total_visits')
                    ->whereYear('date', $currentYear)
                    ->where('status', 'completed')
                    ->groupBy('patient_id')
                    ->get()
                    ->pluck('total_visits', 'patient_id');


        $one_to_two = 0;
        $three_to_five = 0;
        $more_than_five = 0;
        $no_visits = 0;


        $patients = Patient::pluck('id');

        foreach ($patients as $patient_id) {

            $count = $visits[$patient_id] ?? 0; // إذا ما ظهر بالمواعيد = صفر زيارات

            if ($count == 0) {
                $no_visits++;
            } elseif ($count >= 1 && $count <= 2) {
                $one_to_two++;
            } elseif ($count >= 3 && $count <= 5) {
                $three_to_five++;
            } else {
                $more_than_five++;
            }
        }

        return [
            'one_to_two'      => $one_to_two,
            'three_to_five'   => $three_to_five,
            'more_than_five'  => $more_than_five,
            'no_visits'       => $no_visits,
        ];
    }




    public function commonVisitReasons(){
        $currentYear = now()->year;

        $reasons = [
            'General Checkups' => "General Checkup",
            'Chronic Disease Follow-Up' => "Chronic Disease Follow-up",
            'Injuries & Trauma' => "Injury / Trauma",
            'Pediatric Visits' => "Pediatric Consultation",
            'Gynecology Visits' => "Gynecology Consultation",
            'Ophthalmology Visits' => "Ophthalmology Consultation",
            'ENT Visits' => "ENT Consultation",
            'Dental Treatments' => "Dental Treatment",
            'Dermatology Visits' => "Dermatology Consultation",
            'Cardiology Visits' => "Cardiology Consultation",
            'Orthopedic Visits' => "Orthopedic Consultation",
            'Neurology Visits' => "Neurology Consultation",
            'Psychiatry Visits' => "Psychiatry Consultation",
            'Urology/Nephrology Visits' => "Nephrology/Urology Consultation",
            'Oncology Visits' => "Oncology Consultation",
            'Emergency Visits' => "Emergency Visit",
            'Family Medicine Visits' => "Family Medicine Consultation",
            'Surgical Evaluations' => "Surgical Evaluation",
        ];

        $results = [];

        foreach ($reasons as $label => $value) {
            $results[$label] = MedicalRecord::whereYear('record_date', $currentYear)
                ->where('diagnosis', $value)
                ->count();
        }

        $definedCount = array_sum($results);

        $otherCount = MedicalRecord::whereYear('record_date', $currentYear)
            ->whereNotIn('diagnosis', array_values($reasons))
            ->count();

        $results['Other Visits'] = $otherCount;

        return $results;
    }




    public function paymentInsights(){
        $totalInvoices = Invoice::count();

        if ($totalInvoices == 0) {
            return [
                'cash' => 0,
                'bank' => 0,
                'paypal' => 0,
                'cash_percent' => 0,
                'bank_percent' => 0,
                'paypal_percent' => 0
            ];
        }

        $cash = Invoice::where('payment_method', 'Cash')->count();
        $bank = Invoice::where('payment_method', 'Bank')->count();
        $paypal = Invoice::where('payment_method', 'PayPal')->count();

        return [
            'cash' => $cash,
            'bank' => $bank,
            'paypal' => $paypal,
            'cash_percent' => round(($cash / $totalInvoices) * 100),
            'bank_percent' => round(($bank / $totalInvoices) * 100),
            'paypal_percent' => round(($paypal / $totalInvoices) * 100),
        ];
    }




}
