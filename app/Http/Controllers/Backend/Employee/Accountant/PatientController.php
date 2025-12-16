<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller{

    public function viewPatients(){
        $clinic_id = Auth::user()->employee->clinic_id;
        $patients = Patient::whereHas('clinicPatients', function ($q) use ($clinic_id) {
            $q->where('clinic_id', $clinic_id);
        })->orderBy('id', 'asc')->paginate(50);

        return view('Backend.employees.accountants.patients.view' , compact('patients'));
    }


    public function searchPatients(Request $request){
        $keyword = trim((string) $request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $clinicId = Auth::user()->employee->clinic_id;

        $patients = Patient::with('user:id,name,email,phone,address')
        ->whereHas('clinics', function ($q) use ($clinicId) {
            $q->where('clinic_id', $clinicId);
        });

        if ($keyword !== '') {
            switch ($filter) {
                case 'name':
                    $patients->whereHas('user', fn($q) => $q->where('name', 'like', "{$keyword}%"));
                    break;
            }
        }

        $patients   = $patients->orderBy('id')->paginate(50);
        $view       = view('Backend.employees.accountants.patients.search', compact('patients'))->render();
        $pagination = $patients->total() > 50 ? $patients->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $patients->total(),
            'searching'  => $keyword !== '',
        ]);
    }


    public function profilePatient($id){
        $patient = Patient::findOrFail($id);
        return view('Backend.employees.accountants.patients.profile' , compact('patient'));
    }




    public function viewInvoicesPatients($patient_id){
        $clinic_id = Auth::user()->employee->clinic_id;
        $patient = Patient::with('user')->findOrFail($patient_id);
        $invoices = Invoice::where('patient_id' , $patient_id)->where('invoice_status' , 'Issued')->orderBy('id', 'asc')->paginate(10);
        return view('Backend.employees.accountants.patients.invoices.view' , compact('invoices','patient'));
    }



    public function searchInvoicesPatients(Request $request, $patient_id){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');

        $invoices = Invoice::where('patient_id', $patient_id)->with(['patient.user', 'appointment']);

        if ($keyword !== '') {

            switch ($filter) {

                case 'appointment_id':
                    $invoices->where('appointment_id', 'like', "{$keyword}%");
                    break;

                case 'invoice_date':
                    $invoices->where('invoice_date', 'like', "{$keyword}%");
                    break;

                case 'due_date':
                    $invoices->where('due_date', 'like', "{$keyword}%");
                    break;

                case 'payment_status':
                    $invoices->where('payment_status', 'like', "{$keyword}%");
                    break;

                default:
                    $invoices->where(function ($q) use ($keyword) {
                        $q->where('appointment_id', 'like', "%{$keyword}%")
                        ->orWhere('invoice_date', 'like', "%{$keyword}%")
                        ->orWhere('due_date', 'like', "%{$keyword}%")
                        ->orWhere('payment_status', 'like', "%{$keyword}%")
                        ->orWhereHas('patient.user', function ($qq) use ($keyword) {
                            $qq->where('name', 'like', "%{$keyword}%");
                        });
                    });
                    break;
            }
        }

        $invoices = $invoices->orderBy('id', 'asc')->paginate(50);

        $view = view('Backend.employees.accountants.patients.invoices.search', compact('invoices'))->render();

        $pagination = ($invoices->total() > $invoices->perPage())
            ? $invoices->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $invoices->total(),
            'searching'  => $keyword !== '',
        ]);
    }

}
