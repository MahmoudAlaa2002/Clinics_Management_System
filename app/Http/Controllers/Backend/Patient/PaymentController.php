<?php

namespace App\Http\Controllers\Backend\Patient;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\BankPayment;
use Illuminate\Http\Request;
use App\Models\PaypalPayment;
use App\Models\AppointmentHold;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {

    public function chooseMethod($hold_id){
        $hold = AppointmentHold::findOrFail($hold_id);
        $clinic = $hold->clinicDepartment->clinic;
        $hasPaypal = $clinic->paypalAccount !== null;
        return view('Backend.patients.payment.method', compact('hold' , 'hasPaypal'));
    }




    //Bank
    public function bankQr($holdId) {
        $hold = AppointmentHold::with('clinicDepartment.clinic')->findOrFail($holdId);
        $clinic = $hold->clinicDepartment->clinic;
        $amount = $hold->amount;

        return view('Backend.patients.payment.bank.bank_qr',compact('hold','amount','clinic'));
    }

    public function uploadReceipt($holdId) {
        $hold = AppointmentHold::findOrFail($holdId);
        return view('Backend.patients.payment.bank.upload_receipt', compact('hold'));
    }

    public function storeReceipt(Request $request, $holdId) {
        $hold = AppointmentHold::findOrFail($holdId);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('payments', 'public');
        }


        BankPayment::create([
            'hold_id' => $hold->id,
            'reference_number' => $request->reference_number,
            'receipt' => $imagePath,
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'success']);
    }




    //PayPal
    public function payHold($hold_id) {
        $hold = AppointmentHold::where('id', $hold_id)
            ->where('status', 'Pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $clinic = $hold->clinicDepartment->clinic;
        $paypal = $clinic->paypalAccount;

        if (!$paypal) {
            abort(403, 'PayPal account not configured for this clinic');
        }

        /*
        |--------------------------------------------------------------------------
        | Inject PayPal credentials dynamically (PER CLINIC)
        |--------------------------------------------------------------------------
        */
        config([
            'paypal.mode' => $paypal->is_live ? 'live' : 'sandbox',

            'paypal.sandbox.client_id'     => trim($paypal->client_id),
            'paypal.sandbox.client_secret' => trim($paypal->client_secret),

            'paypal.live.client_id'        => trim($paypal->client_id),
            'paypal.live.client_secret'    => trim($paypal->client_secret),

            // REQUIRED by srmklive/paypal
            'paypal.payment_action' => 'Sale',
            'paypal.currency'       => $paypal->currency ?? 'USD',
            'paypal.locale'         => 'en_US',
            'paypal.validate_ssl'   => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create PayPal Provider
        |--------------------------------------------------------------------------
        */
        $provider = new PayPalClient();
        $provider->getAccessToken();

        /*
        |--------------------------------------------------------------------------
        | Create Order
        |--------------------------------------------------------------------------
        */
        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.hold.success', $hold->id),
                'cancel_url' => route('paypal.hold.cancel', $hold->id),
            ],
            'purchase_units' => [[
                'reference_id' => 'HOLD-' . $hold->id,
                'amount' => [
                    'currency_code' => $paypal->currency ?? 'USD',
                    'value' => number_format($hold->amount, 2, '.', ''),
                ],
            ]],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect to PayPal approval
        |--------------------------------------------------------------------------
        */
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return back()->with('error', 'PayPal connection failed');
    }

    public function cancelHold(Request $request, $hold_id) {
        $hold = AppointmentHold::findOrFail($hold_id);
        $clinic = $hold->clinicDepartment->clinic;
        $paypal = $clinic->paypalAccount;

        if ($hold->status === 'Pending') {
            $hold->update(['status' => 'Cancelled']);
        }

        $paypalOrderId = $request->token ?? null;
        $currency = $paypal->currency ?? 'USD';

        PaypalPayment::create([
            'invoice_id'        => null,
            'patient_id'        => $hold->patient_id,
            'clinic_id'         => $hold->clinicDepartment->clinic->id,
            'paypal_order_id'   => $paypalOrderId ?? 'CANCELLED-' . uniqid(),
            'paypal_capture_id' => null,
            'payer_email'       => null,
            'amount'            => $hold->amount,
            'currency'          => $currency,
            'status'            => 'FAILED',
            'paid_at'           => null,
        ]);

        return view('Backend.patients.payment.paypal.cancel');
    }

    public function successHold(Request $request, $hold_id) {
        $hold = AppointmentHold::where('id', $hold_id)
            ->where('status', 'Pending')
            ->firstOrFail();

        $clinic = $hold->clinicDepartment->clinic;
        $paypal = $clinic->paypalAccount;

        if (!$paypal) {
            abort(403, 'PayPal account not configured for this clinic');
        }

        config([
            'paypal.mode' => $paypal->is_live ? 'live' : 'sandbox',

            'paypal.sandbox.client_id'     => trim($paypal->client_id),
            'paypal.sandbox.client_secret' => trim($paypal->client_secret),

            'paypal.live.client_id'        => trim($paypal->client_id),
            'paypal.live.client_secret'    => trim($paypal->client_secret),

            // REQUIRED KEYS
            'paypal.payment_action' => 'Sale',
            'paypal.currency'       => $paypal->currency ?? 'USD',
            'paypal.locale'         => 'en_US',
            'paypal.validate_ssl'   => true,
        ]);

        $provider = new PayPalClient();
        $provider->getAccessToken();

        $result = $provider->capturePaymentOrder($request->token);

        if (!isset($result['status']) || $result['status'] !== 'COMPLETED') {
            return redirect()->route('paypal.hold.cancel', $hold->id);
        }

        DB::transaction(function () use ($hold, $result, $paypal) {

            $appointment = Appointment::create([
                'patient_id'           => $hold->patient_id,
                'doctor_id'            => $hold->doctor_id,
                'clinic_department_id' => $hold->clinic_department_id,
                'date'                 => $hold->date,
                'time'                 => $hold->time,
                'status'               => 'Pending',
                'consultation_fee'     => $hold->amount,
            ]);

            $invoice = Invoice::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $hold->patient_id,
                'total_amount'   => $hold->amount,
                'paid_amount'    => $hold->amount,
                'payment_method' => 'PayPal',
                'payment_status' => 'Paid',
                'invoice_date'   => now()->toDateString(),
                'created_by'     => null,
                'invoice_status' => 'Issued',
            ]);

            PaypalPayment::create([
                'invoice_id'        => $invoice->id,
                'patient_id'        => $hold->patient_id,
                'clinic_id'         => $hold->clinicDepartment->clinic->id,
                'paypal_order_id'   => $result['id'],
                'paypal_capture_id' => $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                'payer_email'       => $result['payer']['email_address'] ?? null,
                'amount'            => $hold->amount,
                'currency'          => $paypal->currency ?? 'USD',
                'status'            => 'COMPLETED',
                'paid_at'           => Carbon::parse(
                    $result['purchase_units'][0]['payments']['captures'][0]['create_time']
                ),
            ]);

            $hold->delete();
        });

        return view('Backend.patients.payment.paypal.success', [
            'transaction' => $result
        ]);
    }

}
