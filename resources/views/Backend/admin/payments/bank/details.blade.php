@extends('Backend.admin.master')

@section('title', 'Payment & Appointment Details')

@section('content')

@php
    $source = $payment->appointment ?? $payment->hold;
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
        grid-template-columns:380px 1fr;
        gap:40px;
    }

    .receipt-box {
        background:#fff;
        border-radius:20px;
        padding:25px;
        border:1px solid #e3f2fd;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
        text-align:center;
    }

    .receipt-box img {
        max-width:100%;
        border-radius:16px;
        box-shadow:0 10px 25px rgba(0,0,0,.15);
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
    .detail-value { font-size:17px; font-weight:600; color:#222; }

    .amount-box {
        background:linear-gradient(135deg,#00c853,#64dd17);
        color:#fff;
    }

    .status-pill {
        padding:8px 22px;
        border-radius:50px;
        font-size:14px;
        font-weight:700;
    }
</style>

<div class="page-wrapper">
    <div class="content payment-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="payment-card">

                    <div class="payment-title">
                        <i class="fas fa-credit-card"></i>
                        Payment & Appointment Details
                    </div>

                    <div class="payment-layout">

                        {{-- LEFT: Receipt --}}
                        <div class="receipt-box">
                            <img src="{{ asset($payment->receipt) }}">
                            <p class="mt-3 text-muted">Uploaded Payment Receipt</p>
                        </div>

                        {{-- RIGHT: Details --}}
                        <div class="details-grid">

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-hashtag"></i></div>
                                <div class="detail-title">Transaction</div>
                                <div class="detail-value">#{{ $payment->id }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-user-injured"></i></div>
                                <div class="detail-title">Patient</div>
                                <div class="detail-value">{{ $source->patient->user->name }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-user-md"></i></div>
                                <div class="detail-title">Doctor</div>
                                <div class="detail-value">{{ $source->doctor->employee->user->name }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-hospital"></i></div>
                                <div class="detail-title">Clinic</div>
                                <div class="detail-value">{{ $source->clinicDepartment->clinic->name }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-building"></i></div>
                                <div class="detail-title">Department</div>
                                <div class="detail-value">{{ $source->clinicDepartment->department->name }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-calendar-day"></i></div>
                                <div class="detail-title">Date</div>
                                <div class="detail-value">{{ $source->date }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-clock"></i></div>
                                <div class="detail-title">Time</div>
                                <div class="detail-value">{{ \Carbon\Carbon::parse($source->time)->format('h:i A') }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-barcode"></i></div>
                                <div class="detail-title">Reference</div>
                                <div class="detail-value">{{ $payment->reference_number }}</div>
                            </div>

                            <div class="detail-box amount-box">
                                <div class="text-white detail-icon"><i class="fas fa-dollar-sign"></i></div>
                                <div class="text-white detail-title">Amount</div>
                                <div class="detail-value fs-4">$ {{ $source->consultation_fee ?? $source->amount }}</div>
                            </div>

                            <div class="detail-box">
                                <div class="detail-icon"><i class="fas fa-info-circle"></i></div>
                                <div class="detail-title" style="margin-bottom:10px;">Status</div>

                                @if($payment->status == 'approved')
                                    <span class="status-pill" style="background:#00c853;color:white;">Approved</span>
                                @elseif($payment->status == 'pending')
                                    <span class="status-pill" style="background:#ffc107;color:white">Pending</span>
                                @else
                                    <span class="status-pill" style="background:#f44336;color:white">Rejected</span>
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
