@extends('Backend.master')

@section('title', 'Patient Invoice')

@section('content')
<style>
    .invoice-card {
        max-width: 700px;
        margin: 60px auto;
        background: #ffffff;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
        color: #2c3e50;
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

<div class="invoice-card">
    <div class="invoice-header">
        <img src="{{ asset('assets/img/logo-dark.png') }}" alt="Clinic Logo">
        <div class="invoice-title">Patient Invoice</div>
    </div>

    <div class="invoice-meta">
        <div style="color: black;">Invoice ID : <strong>#INV-{{ $patientInvoice->id }}</strong></div>
        <div style="color: black;">Issue Date : <strong>{{ $patientInvoice->created_at?->format('Y-m-d') ?? '--' }}</strong></div>
    </div>

    <hr style="margin-top: 40px; border: 1.5px solid #111827;">

    <div class="invoice-grid">
        <div class="invoice-item">
            <div class="label">Clinic Name</div>
            <div class="value">{{ $patientInvoice->appointment->clinic->name ?? '---' }}</div>
        </div>

        <div class="invoice-item">
            <div class="label">Appointment ID</div>
            <div class="value" style="margin-left:30px;">{{ $patientInvoice->appointment_id ?? '---' }}</div>
        </div>

        <div class="invoice-item">
            <div class="label">Patient</div>
            <div class="value">{{ $patientInvoice->patient->name ?? 'N/A' }}</div>
        </div>

        <div class="invoice-item">
            <div class="label">Total Amount</div>
            <div class="value">$ {{ number_format($patientInvoice->total_amount, 2) }}</div>
        </div>

        <div class="invoice-item">
            <div class="label">Discount</div>
            <div class="value">$ {{ number_format($patientInvoice->discount, 2) }}</div>
        </div>

        <div class="invoice-item">
            <div class="label">Final Amount</div>
            <div class="value">$ {{ number_format($patientInvoice->final_amount, 2) }}</div>
        </div>
    </div>

    @if($patientInvoice->items && $patientInvoice->items->count())
    <h4 style="margin-top: 30px; font-weight: bold; color: #374151;">Invoice Items</h4>
    <table class="invoice-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($patientInvoice->items as $index => $item)
                @php $total += $item->total_amount; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->service_name }}</td>
                    <td style="text-transform: capitalize;">{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->total_amount, 2) }}</td>
                </tr>
            @endforeach
            <!-- صف المجموع الكلي -->
            <tr>
                <td colspan="4" style="border: none;"></td>
                <td style="text-align: center; font-weight: bold;">Total = ${{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
@endif

    <div class="notes">
        <strong>Notes:</strong><br>
        {{ $patientInvoice->notes ?? 'No notes provided.' }}
    </div>

    <div class="actions">
        <a href="{{ route('view_invoices') }}" class="btn btn-back">Back</a>
        <a href="#" onclick="window.print()" class="btn btn-print">Print</a>
    </div>
</div>
@endsection
