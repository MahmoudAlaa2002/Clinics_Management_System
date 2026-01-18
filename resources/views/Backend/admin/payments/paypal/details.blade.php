@extends('Backend.admin.master')

@section('title', 'PayPal Payment Details')

@section('content')

@php
    $invoice     = $payment->invoice;
    $appointment = optional($invoice)->appointment;
    $patient     = optional(optional($appointment)->patient)->user;
@endphp

<style>
    .payment-wrapper { margin-top:40px; }

    .payment-card {
        background:linear-gradient(135deg,#ffffff,#f4f9ff);
        border-radius:20px;
        padding:40px;
        box-shadow:0 20px 50px rgba(0,0,0,.08);
        border:1px solid #e3f2fd;
    }

    .payment-title {
        font-size:30px;
        font-weight:800;
        color:#039be5;
        margin-bottom:35px;
        display:flex;
        align-items:center;
        gap:12px;
    }

    .payment-title i {
        font-size:32px;
        background:linear-gradient(135deg,#03A9F4,#0288d1);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
    }

    .payment-layout {
        display:grid;
        grid-template-columns:1fr;
        gap:40px;
    }

    .details-grid {
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
        gap:22px;
    }

    .detail-box {
        background:rgba(255,255,255,.75);
        backdrop-filter:blur(6px);
        padding:22px;
        border-radius:16px;
        border:1px solid #e3f2fd;
        box-shadow:0 6px 20px rgba(3,169,244,.08);
        transition:.3s;
    }

    .detail-box:hover {
        transform:translateY(-4px);
        box-shadow:0 12px 28px rgba(3,169,244,.18);
    }

    .detail-icon { font-size:26px; color:#03A9F4; margin-bottom:10px; }
    .detail-title { font-size:13px; font-weight:700; color:#777; text-transform:uppercase; }
    .detail-value { font-size:17px; font-weight:600; color:#222; word-break:break-all; }

    .amount-box {
        background:linear-gradient(135deg,#00c853,#64dd17);
        color:#fff;
    }

    .status-pill {
        padding:8px 22px;
        border-radius:50px;
        font-size:14px;
        font-weight:700;
        display:inline-block;
    }
</style>

<div class="page-wrapper">
    <div class="content payment-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="payment-card">

                    <div class="payment-title">
                        <i class="fab fa-paypal"></i>
                        PayPal Payment Details
                    </div>

                    <div class="payment-layout">

                        <div class="details-grid">

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-hashtag"></i></div>
                                <div class="detail-title">Payment ID</div>
                                <div class="detail-value">#{{ $payment->id }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-user-injured"></i></div>
                                <div class="detail-title">Patient</div>
                                <div class="detail-value">{{ $patient->name ?? '—' }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-receipt"></i></div>
                                <div class="detail-title">PayPal Order ID</div>
                                <div class="detail-value">{{ $payment->paypal_order_id }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-key"></i></div>
                                <div class="detail-title">Capture ID</div>
                                <div class="detail-value">{{ $payment->paypal_capture_id ?? '—' }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                                <div class="detail-title">Payer Email</div>
                                <div class="detail-value">{{ $payment->payer_email ?? '—' }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-calendar-check"></i></div>
                                <div class="detail-title">Paid At</div>
                                <div class="detail-value">
                                    {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : '—' }}
                                </div>
                            </div>

                            <div class="detail-box amount-box">
                                <div class="text-white detail-icon"><i class="fas fa-dollar-sign"></i></div>
                                <div class="text-white detail-title">Amount</div>
                                <div class="detail-value fs-4">
                                    {{ number_format($payment->amount, 2) }} {{ $payment->currency }}
                                </div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-info-circle"></i></div>
                                <div class="detail-title">Status</div>

                                @if($payment->status === 'COMPLETED')
                                    <span class="status-pill" style="background:#00c853;color:white;">Completed</span>
                                @elseif($payment->status === 'FAILED')
                                    <span class="status-pill" style="background:#f44336;color:white;">Failed</span>
                                @elseif($payment->status === 'CREATED')
                                    <span class="status-pill" style="background:#ffc107;color:white;">Created</span>
                                @elseif($payment->status === 'REFUNDED')
                                    <span class="status-pill" style="background:#6c757d;color:white;">Refunded</span>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
