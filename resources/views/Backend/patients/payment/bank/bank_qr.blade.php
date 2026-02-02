@extends('Backend.patients.master')

@section('title','Bank of Palestine Payment')

@section('content')

<div style="max-width:700px;margin:60px auto;text-align:center">

    <h2 style="color:#00A8FF;font-weight:900">
        {{ $clinic->name }} Account QR Code
    </h2>

    <p>Appointment Fee</p>

    <h1 style="font-size:42px;color:#0f766e">
        $ {{ number_format($amount, 2) }}
    </h1>

    {{-- QR الخاص بالعيادة --}}
    <div style="margin:30px auto">
        @if(!empty($clinic->qr_image))
            <img src="{{ asset('storage/'.$clinic->qr_image) }}" width="300" alt="Clinic Bank QR">
        @else
            <div style="border:2px dashed #cbd5e1; padding:30px; border-radius:12px;
                    color:#475569; font-size:16px; background:#f8fafc;">
                    No QR code available<br>
                    You can complete the transfer using the clinic’s phone number.
            </div>
        @endif
    </div>


    <p style="margin-top:10px">
        Scan this code using <strong>Banky</strong> or <strong>PalPay</strong><br>
        Recipient:<strong>{{ $clinic->phone }}</strong>
    </p>

    <a href="{{ route('patient.bank.qr.upload',$hold->id) }}"
        class="mt-4 btn btn-success btn-lg">
        Upload Proof of Payment
    </a>

</div>

@endsection
