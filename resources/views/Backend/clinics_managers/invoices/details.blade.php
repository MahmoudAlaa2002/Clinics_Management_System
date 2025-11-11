@extends('Backend.clinics_managers.master')

@section('title', 'Patient Invoice')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        background-color: #f8f9fa;
        overflow-x: hidden;
    }

    /* 🔹 غلاف عام لتوسيط الفاتورة وجعلها تتفاعل مع sidebar */
    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 40px 20px;
        transition: margin-left 0.3s ease; /* عشان تتحرك بسلاسة مع sidebar */
    }

    /* 🔹 لما تتسكر لوحة التحكم (sidebar)، المحتوى يتحرك */
    .mini-sidebar .page-wrapper {
        margin-left: 80px !important;
    }

    .invoice-card {
        max-width: 700px;
        width: 100%;
        background: #ffffff;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
        color: #2c3e50;
        margin: auto;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .invoice-header img {
        width: 60px;
        height: 60px;
    }

    .invoice-title {
        font-size: 28px;
        font-weight: 700;
        color: #03A9F4;
        margin-top: 15px;
    }

    .invoice-meta {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #6b7280;
        margin-top: 20px;
    }

    .invoice-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        font-size: 14px;
        margin-top: 30px;
        gap: 20px;
    }

    .invoice-item {
        margin-bottom: 20px;
    }

    .invoice-item .label {
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .invoice-item .value {
        font-weight: 600;
        color: black;
    }

    table.invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        font-size: 14px;
    }

    .invoice-table th, .invoice-table td {
        padding: 12px;
        border: 1px solid #e5e7eb;
        text-align: left;
    }

    .invoice-table thead {
        background-color: #f3f4f6;
    }

    .invoice-table td:last-child, .invoice-table th:last-child {
        text-align: right;
    }

    .notes {
        font-size: 13px;
        color: black;
        margin-top: 25px;
        background: #c9c8c8;
        padding: 15px;
        border-radius: 8px;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        gap: 10px;
    }

    .btn {
        flex: 1;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.3s;
    }

    .btn-back {
        background-color: #03A9F4;
        color: white;
    }

    .btn-back:hover {
        background-color: #0288d1;
        color: white;
    }

    .btn-print {
        background-color: #10b981;
        color: white;
    }

    .btn-print:hover {
        background-color: #059669;
        color: white;
    }

</style>

<div class="page-wrapper">
    <div class="invoice-card">
        <div class="invoice-header">
            <img src="{{ asset('assets/img/logo-dark.png') }}" alt="Clinic Logo">
            <div class="invoice-title">Patient Invoice</div>
        </div>

        <div class="invoice-meta">
            <div style="color: black;">Invoice ID : <strong>#INV-{{ $invoice->id }}</strong></div>
            <div style="color: black;">Issue Date : <strong>{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : '-' }}</strong></div>
        </div>

        <hr style="margin-top: 40px; border: 1.5px solid #111827;">

        <div class="invoice-grid">
            <div class="invoice-item">
                <div class="label">Clinic Name</div>
                <div class="value">{{ $invoice->appointment->clinicDepartment->clinic->name ?? 'N/A' }}</div>
            </div>

            <div class="invoice-item">
                <div class="label">Appointment ID</div>
                <div class="value" style="margin-left:30px;">{{ $invoice->appointment_id ?? '---' }}</div>
            </div>

            <div class="invoice-item">
                <div class="label">Patient</div>
                <div class="value">{{ $invoice->patient->user->name ?? 'N/A' }}</div>
            </div>

            <div class="invoice-item">
                <div class="label">Total Amount</div>
                <div class="value">$ {{ number_format($invoice->total_amount, 2) }}</div>
            </div>

            <div class="invoice-item">
                <div class="label">Due Date</div>
                <div class="value">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '-' }}</div>
            </div>

            <div class="invoice-item">
                <div class="label">Status</div>
                <div class="value">
                    @if ($invoice->payment_status === 'Paid')
                        <span>Paid</span>
                    @elseif ($invoice->payment_status === 'Partially Paid')
                        <span>Partially Paid</span>
                    @else
                        <span>Unpaid</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('clinic.view_invoices') }}" class="btn btn-back">Back</a>
            <a href="#" onclick="window.print()" class="btn btn-print">Print</a>
        </div>
    </div>
</div>
@endsection
