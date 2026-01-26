<?php

namespace App\Http\Controllers\Backend\Employee\Accountant;

use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\BankPayment;
use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use App\Models\AppointmentHold;
use App\Models\ClinicDepartment;
use App\Events\BankPaymentReviewed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller{


    // ********** Pending ********** //

    public function index() {
        $clinicId = auth()->user()->employee->clinic_id;
        $payments = BankPayment::where('status', 'pending')
            ->whereHas('hold.clinicDepartment', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            })->with([
                'hold.patient.user',
                'hold.doctor.employee.user',
                'hold.clinicDepartment.clinic'
            ])->latest()->paginate(50);

        return view('Backend.employees.accountants.payments.pending.view', compact('payments'));
    }




    public function search(Request $request){
        $keyword = trim($request->input('keyword', ''));
        $filter  = $request->input('filter', '');
        $clinicId = auth()->user()->employee->clinic_id;

        $payments = BankPayment::where('status','pending')
            ->whereHas('hold.clinicDepartment', function ($q) use ($clinicId) {
                $q->where('clinic_id', $clinicId);
            })->with([
                'hold.patient.user',
                'hold.doctor.employee.user',
                'hold.clinicDepartment.clinic'
            ]);

        if ($keyword !== '') {
            switch ($filter) {
                case 'reference_number':
                    $payments->where('reference_number', 'like', "{$keyword}%");
                    break;

                default:
                    $payments->where(function ($q) use ($keyword) {
                        $q->Where('reference_number', 'like', "%{$keyword}%");
                    });
                    break;
            }
        }

        $payments = $payments->orderBy('id', 'asc')->paginate(50);
        $view = view('Backend.employees.accountants.payments.pending.search', compact('payments'))->render();
        $pagination = $payments->total() > 50 ? $payments->links('pagination::bootstrap-4')->render() : '';

        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
            'count'      => $payments->total(),
            'searching'  => $keyword !== '',
        ]);
    }





    public function details($id) {
        $hold_appointment = AppointmentHold::with([
            'patient.user',
            'doctor.employee.user',
            'clinicDepartment'
        ])->findOrFail($id);
        return view('Backend.employees.accountants.payments.pending.details', compact('hold_appointment'));
    }




    public function approve($paymentId) {
        $payment = BankPayment::findOrFail($paymentId);
        $hold = AppointmentHold::findOrFail($payment->hold_id);

        // حالة نادرة 🔴 فحص هل الموعد محجوز مسبقًا؟ 🔴
        $alreadyBooked = Appointment::where('doctor_id', $hold->doctor_id)
            ->where('date', $hold->date)
            ->where('time', $hold->time)
            ->whereIn('status', ['Pending', 'Accepted', 'Completed'])->exists();

        if ($alreadyBooked) {
            return response()->json([
                'status'  => 'conflict',
            ], 409);

        }

        $appointment = Appointment::create([
            'patient_id' => $hold->patient_id,
            'doctor_id' => $hold->doctor_id,
            'clinic_department_id' => $hold->clinic_department_id,
            'date' => $hold->date,
            'time' => $hold->time,
            'notes' => $hold->notes,
            'status' => 'Pending',
            'is_active' => 1,
            'consultation_fee' => $hold->amount
        ]);

        Invoice::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $hold->patient_id,
            'total_amount' => $hold->amount,
            'paid_amount' => $hold->amount,
            'payment_method' => 'Bank',
            'payment_status' => 'Paid',
            'invoice_date' => now()->toDateString(),
            'created_by' => auth()->user()->employee->id ?? null,
            'invoice_status' => 'Issued'
        ]);

        $payment->update([
            'status' => 'approved',
            'appointment_id' => $appointment->id,
            'hold_id' => null
        ]);

        $hold->delete();

        BankPaymentReviewed::dispatch($payment, auth()->user(), 'approved');

        return response()->json(['status' => 'success']);
    }




    public function reject(Request $request, $paymentId) {
        $payment = BankPayment::findOrFail($paymentId);
        $hold = AppointmentHold::findOrFail($payment->hold_id);
        $payment->update([
            'status' => 'rejected'
        ]);

        $hold->update([
            'status' => 'Cancelled'
        ]);

        BankPaymentReviewed::dispatch($payment, auth()->user(),'rejected');


        return redirect()->route('accountant.bank_payments.pending')->with('error','Payment has been rejected');
    }




    // ********** Bank ********** //

    public function viewBankPayments() {
        $clinicId = auth()->user()->employee->clinic_id;

        $payments = BankPayment::where(function ($q) use ($clinicId) {
                $q->whereHas('appointment.clinicDepartment', function ($q) use ($clinicId) {
                    $q->where('clinic_id', $clinicId);
                })->orWhereHas('hold.clinicDepartment', function ($q) use ($clinicId) {
                    $q->where('clinic_id', $clinicId);
                });
            })->with([
                // Approved
                'appointment.patient.user',
                'appointment.doctor.employee.user',
                'appointment.clinicDepartment.clinic',

                // Pending أو Rejected
                'hold.patient.user',
                'hold.doctor.employee.user',
                'hold.clinicDepartment.clinic',
            ])->paginate(50);

        return view('Backend.employees.accountants.payments.bank.view', compact('payments'));
    }




    public function searchBankPayments(Request $request) {
        $keyword  = trim($request->input('keyword',''));
        $filter   = $request->input('filter','');
        $clinicId = auth()->user()->employee->clinic_id;

        $payments = BankPayment::query()

            // فلترة حسب العيادة (سواء من appointment أو hold)
            ->leftJoin('appointments','bank_payments.appointment_id','=','appointments.id')
            ->leftJoin('appointment_holds','bank_payments.hold_id','=','appointment_holds.id')
            ->leftJoin('clinic_departments', function($join){
                $join->on('clinic_departments.id','=','appointments.clinic_department_id')
                    ->orOn('clinic_departments.id','=','appointment_holds.clinic_department_id');
            })
            ->where('clinic_departments.clinic_id',$clinicId)

            ->select('bank_payments.*')

            // العلاقات للعرض
            ->with([
                'appointment.patient.user',
                'appointment.doctor.employee.user',
                'appointment.clinicDepartment.clinic',
                'hold.patient.user',
                'hold.doctor.employee.user',
                'hold.clinicDepartment.clinic',
            ]);

        if($keyword !== ''){

            switch($filter){

                case 'patient_name':
                    $payments->where(function($q) use ($keyword){
                        $q->whereHas('appointment.patient.user', function($q) use ($keyword){
                            $q->where('name','like',"$keyword%");
                        })->orWhereHas('hold.patient.user', function($q) use ($keyword){
                            $q->where('name','like',"$keyword%");
                        });
                    });
                    break;

                case 'amount':
                    $payments->where(function($q) use ($keyword){
                        $q->whereHas('appointment', function($q) use ($keyword){
                            $q->where('consultation_fee','like',"$keyword%");
                        })->orWhereHas('hold', function($q) use ($keyword){
                            $q->where('amount','like',"$keyword%");
                        });
                    });
                    break;

                case 'reference_number':
                    $payments->where('bank_payments.reference_number','like',"$keyword%");
                    break;

                case 'status':
                    $payments->where('bank_payments.status' ,'like' ,"$keyword%");
                    break;
            }
        }

        $payments = $payments->latest('bank_payments.created_at')->paginate(50);

        $view = view('Backend.employees.accountants.payments.bank.search', compact('payments'))->render();
        $pagination = $payments->total() > 50
            ? $payments->links('pagination::bootstrap-4')->render()
            : '';

        return response()->json([
            'html' => $view,
            'pagination' => $pagination,
            'count' => $payments->total(),
            'searching' => $keyword !== ''
        ]);
    }




    public function detailsBankPayments($id) {
        $clinicId = auth()->user()->employee->clinic_id;

        $payment = BankPayment::where('id',$id)
            ->where(function ($q) use ($clinicId) {
                $q->whereHas('appointment.clinicDepartment', function ($q) use ($clinicId) {
                    $q->where('clinic_id',$clinicId);
                })
                ->orWhereHas('hold.clinicDepartment', function ($q) use ($clinicId) {
                    $q->where('clinic_id',$clinicId);
                });
            })->with([
                'appointment.patient.user',
                'appointment.doctor.employee.user',
                'appointment.clinicDepartment.clinic',

                'hold.patient.user',
                'hold.doctor.employee.user',
                'hold.clinicDepartment.clinic',
            ])->firstOrFail();


        return view('Backend.employees.accountants.payments.bank.details', compact('payment'));
    }







    // ********** Paypal ********** //

    public function viewPaypalPayments() {
        $clinicId = auth()->user()->employee->clinic_id;
        $payments = PaypalPayment::where('clinic_id', $clinicId)->with([
                'invoice.appointment.patient.user'
            ])->paginate(50);

        return view('Backend.employees.accountants.payments.paypal.view',compact('payments'));
    }



    public function searchPaypalPayments(Request $request) {
        $clinicId = auth()->user()->employee->clinic_id;
        $keyword  = trim($request->input('keyword', ''));
        $filter   = $request->input('filter', '');

        $payments = PaypalPayment::where('clinic_id', $clinicId)->with([
                'invoice.appointment.patient.user'
            ]);

        if ($keyword !== '') {
            switch ($filter) {

                case 'patient_name':
                    $payments->whereHas(
                        'invoice.appointment.patient.user',
                        fn ($q) => $q->where('name', 'like', "$keyword%")
                    );break;

                case 'order_id':
                    $payments->where('paypal_order_id', 'like', "$keyword%");
                    break;

                case 'paid_at':
                    $payments->whereDate('paid_at', $keyword);
                    break;

                case 'status':
                    $payments->where('status', 'like', "$keyword%");
                    break;

                default:
                    $payments->where(function ($q) use ($keyword) {
                        $q->where('paypal_order_id', 'like', "%$keyword%")
                        ->orWhereHas(
                            'invoice.appointment.patient.user',
                            fn ($q) => $q->where('name', 'like', "%$keyword%")
                        );
                    });
                    break;
            }
        }

        $payments = $payments->latest()->paginate(50);
        return response()->json(['html' => view('Backend.employees.accountants.payments.paypal.search',compact('payments'))->render(),
            'pagination' => $payments->total() > 50 ? $payments->links('pagination::bootstrap-4')->render() : '',
            'count'     => $payments->total(),
            'searching' => $keyword !== '',
        ]);
    }



    public function detailsPaypalPayments($id) {
        $payment = PaypalPayment::with([
            'invoice.appointment.patient.user',
        ])->findOrFail($id);

        return view('Backend.employees.accountants.payments.paypal.details', ['payment' => $payment]);
    }

}
