<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\BankPayment;
use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {
    
    public function viewBankPayments() {
        $payments = BankPayment::with([
            'appointment.patient.user',
            'appointment.doctor.employee.user',
            'appointment.clinicDepartment.clinic',
    
            'hold.patient.user',
            'hold.doctor.employee.user',
            'hold.clinicDepartment.clinic',
        ])->paginate(50);
    
        return view('Backend.admin.payments.bank.view', compact('payments'));
    }


    public function searchBankPayments(Request $request) {
        $keyword = trim($request->input('keyword',''));
        $filter  = $request->input('filter','');
    
        $payments = BankPayment::query()->with([
            'appointment.patient.user',
            'appointment.doctor.employee.user',
            'appointment.clinicDepartment.clinic',
            'hold.patient.user',
            'hold.doctor.employee.user',
            'hold.clinicDepartment.clinic',
        ]);
    
        if ($keyword !== '') {
            switch ($filter) {
    
                case 'patient_name':
                    $payments->where(function ($q) use ($keyword) {
                        $q->whereHas('appointment.patient.user', fn ($q) =>
                            $q->where('name','like',"$keyword%")
                        )->orWhereHas('hold.patient.user', fn ($q) =>
                            $q->where('name','like',"$keyword%")
                        );
                    });
                    break;

                case 'clinic_name':
                    $payments->where(function ($q) use ($keyword) {
                        $q->whereHas('appointment.clinicDepartment.clinic', fn ($q) =>
                            $q->where('name','like',"$keyword%")
                        )->orWhereHas('hold.clinicDepartment.clinic', fn ($q) =>
                            $q->where('name','like',"$keyword%")
                        );
                    });
                    break;
    
                case 'reference_number':
                    $payments->where('reference_number','like',"$keyword%");
                    break;
    
                case 'status':
                    $payments->where('status','like',"$keyword%");
                    break;
            }
        }
    
        $payments = $payments->paginate(50);
    
        return response()->json([
            'html' => view('Backend.admin.payments.bank.search', compact('payments'))->render(),
            'pagination' => $payments->total() > 50
                ? $payments->links('pagination::bootstrap-4')->render()
                : '',
            'count' => $payments->total(),
            'searching' => $keyword !== '',
        ]);
    }


    public function detailsBankPayments($id) {
        $payment = BankPayment::with([
            'appointment.patient.user',
            'appointment.doctor.employee.user',
            'appointment.clinicDepartment.clinic',
    
            'hold.patient.user',
            'hold.doctor.employee.user',
            'hold.clinicDepartment.clinic',
        ])->findOrFail($id);
    
        return view('Backend.admin.payments.bank.details', compact('payment'));
    }

    
    public function viewPaypalPayments() {
        $payments = PaypalPayment::with([
            'invoice.appointment.patient.user',
            'invoice.appointment.clinicDepartment.clinic',
        ])->paginate(50);
    
        return view('Backend.admin.payments.paypal.view', compact('payments'));
    }


    public function searchPaypalPayments(Request $request) {
        $keyword = trim($request->input('keyword',''));
        $filter  = $request->input('filter','');
    
        $payments = PaypalPayment::with([
            'invoice.appointment.patient.user',
            'invoice.appointment.clinicDepartment.clinic',
        ]);
    
        if ($keyword !== '') {
            switch ($filter) {
    
                case 'patient_name':
                    $payments->whereHas(
                        'invoice.appointment.patient.user',
                        fn ($q) => $q->where('name','like',"$keyword%")
                    );
                    break;
    
                case 'order_id':
                    $payments->where('paypal_order_id','like',"$keyword%");
                    break;
    
                case 'paid_at':
                    $payments->whereDate('paid_at', 'like',"$keyword%");
                    break;
    
                case 'status':
                    $payments->where('status','like',"$keyword%");
                    break;
    
                default:
                    $payments->where(function ($q) use ($keyword) {
                        $q->where('paypal_order_id','like',"%$keyword%")
                          ->orWhereHas(
                              'invoice.appointment.patient.user',
                              fn ($q) => $q->where('name','like',"%$keyword%")
                          );
                    });
            }
        }
    
        $payments = $payments->paginate(50);
    
        return response()->json([
            'html' => view('Backend.admin.payments.paypal.search', compact('payments'))->render(),
            'pagination' => $payments->total() > 50
                ? $payments->links('pagination::bootstrap-4')->render()
                : '',
            'count' => $payments->total(),
            'searching' => $keyword !== '',
        ]);
    }

    

    public function detailsPaypalPayments($id) {
        $payment = PaypalPayment::with([
            'invoice.appointment.patient.user',
            'invoice.appointment.clinicDepartment.clinic',
        ])->findOrFail($id);
    
        return view('Backend.admin.payments.paypal.details', compact('payment'));
    }
    
    
    
    
}
