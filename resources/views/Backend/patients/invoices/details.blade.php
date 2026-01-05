@extends('Backend.patients.master')

@section('title', 'Patient Invoice')

@section('content')

<style>
    .content-fluid {
        transition: all 0.3s ease;
        padding: 20px;
    }

    .invoice-wrapper {
        max-width: 800px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 16px;
        padding: 45px 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .invoice-logo img {
        width: 80px;
    }

    .invoice-header-text h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: #03A9F4;
    }

    .invoice-header-text p {
        font-size: 14px;
        margin: 4px 0;
        color: #6b7280;
    }

    hr {
        border: 0;
        border-top: 1.5px solid #e5e7eb;
        margin: 30px 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 40px;
        margin-bottom: 35px;
    }

    .info-item .label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .info-item .value {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
    }

    table.invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 15px;
    }

    .invoice-table th {
        text-align: left;
        padding: 14px;
        background: #f3f4f6;
        color: #111827;
        font-weight: 700;
    }

    .invoice-table td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .created-by {
        text-align: center;
        margin-top: 40px;
        font-size: 14px;
        color: #374151;
    }

    .created-by span {
        font-weight: 700;
        color: #03A9F4;
    }

    .action-buttons {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }

    .btn-custom {
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        color: white;
        transition: 0.3s;
    }

    .btn-back {
        background: #03A9F4;
    }

    .btn-back:hover {
        background: #0288d1;
        color: white;
    }

    .btn-print {
        background: #10b981;
    }

    .btn-print:hover {
        background: #059669;
        color: white;
    }

</style>

<div class="content-fluid">
<div class="invoice-wrapper">

    <div class="header-flex">
        <div class="invoice-header-text">
            <h2>Invoice</h2>
            <p><strong>Invoice ID:</strong> #INV-{{ $invoice->id }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date ?? '-' }}</p>
        </div>

        <div class="invoice-logo">
            <img src="{{ asset('assets/img/logo-dark.png') }}">
        </div>
    </div>

    <hr>

    <div class="info-grid">
        <div class="info-item">
            <div class="label">Clinic</div>
            <div class="value">{{ $invoice->appointment->clinicDepartment->clinic->name ?? 'N/A' }}</div>
        </div>

        <div class="info-item">
            <div class="label">Appointment ID</div>
            <div class="value">#{{ $invoice->appointment_id }}</div>
        </div>

        <div class="info-item">
            <div class="label">Patient</div>
            <div class="value">{{ $invoice->patient->user->name ?? 'N/A' }}</div>
        </div>

        <div class="info-item">
            <div class="label">Payment Method</div>
            <div class="value">{{ $invoice->payment_method }}</div>
        </div>

        <div class="info-item">
            <div class="label">Due Date</div>
            <div class="value">{{ $invoice->due_date ?? '-' }}</div>
        </div>

        <div class="info-item">
            <div class="label">Status</div>
            <div class="value">{{ $invoice->payment_status }}</div>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consultation Fee</td>
                <td style="text-align:right;">$ {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>

            <tr>
                <td><strong>Paid Amount</strong></td>
                <td style="text-align:right;"><strong>$ {{ number_format($invoice->paid_amount, 2) }}</strong></td>
            </tr>

            <tr>
                <td><strong>Remaining</strong></td>
                <td style="text-align:right;"><strong>$ {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="created-by">
        Created By <span>{{ $invoice->creator->user->name ?? 'Admin' }}</span>
    </div>


    @if($invoice->payment_status === 'Paid')
        <div style="margin-top: 60px; text-align: left;">
            <p style="font-size: 14px; color:#6b7280;">Authorized Signature</p>
            <img src="{{ asset('assets/img/signature/t3.png') }}" style="width: 180px; margin-bottom: 8px;">
        </div>
    @endif

    <div class="action-buttons">
        <a href="{{ route('patient.invoices_view') }}" class="btn-custom btn-back">Back</a>
        <a href="{{ route('patient.invoice_pdf', $invoice->id) }}" class="btn-custom btn-print">Print</a>
    </div>

</div>
</div>

@endsection
