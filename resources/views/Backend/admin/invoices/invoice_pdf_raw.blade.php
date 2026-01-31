<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 90%;
            margin: 0 auto;
            padding: 20px 15px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-title {
            color: #03A9F4;
            font-size: 28px;
            font-weight: bold;
        }

        .meta {
            color: #374151;
            font-size: 14px;
            margin-top: 6px;
        }

        .logo {
            text-align: right;
        }

        .logo img {
            width: 80px;
        }

        hr {
            border: 0;
            border-top: 1px solid #9ca3af;
            margin: 25px 0;
        }

        /* INFO TABLE */
        .info-table {
            width: 100%;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 14px 0;
        }

        .label {
            font-size: 11px;
            color: #6b7280;
        }

        .value {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }

        /* PAYMENT TABLE */
        .pay-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 60px;
            font-size: 14px;
        }

        .pay-table th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #d1d5db;
        }

        .pay-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .text-right {
            text-align: right;
        }

        .created {
            text-align: center;
            margin-top: 100px;
            font-size: 13px;
            color: #374151;
        }

        .created span {
            color: #03A9F4;
            font-weight: bold;
        }

        .signature {
            margin-top: 130px;
            text-align: left;
        }

        .signature img {
            width: 180px;
        }

        .pay-table th.text-right,
        .pay-table td.text-right {
            text-align: right;
            padding-right: 25px;
        }


    </style>
</head>

<body>

<div class="wrapper">

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Invoice</div>
                <div class="meta"><strong>Date:</strong> {{ $invoice->invoice_date }}</div>
                <div class="meta"><strong>Invoice ID:</strong> #INV-{{ $invoice->id }}</div>
            </td>

            <td class="logo">
                <img src="{{ public_path('assets/img/logo-dark.png') }}" alt="Logo">
            </td>
        </tr>
    </table>

    <hr>

    <!-- INFO SECTION -->
    <table class="info-table">
        <tr>
            <td>
                <div class="label">CLINIC</div>
                <div class="value">{{ $invoice->appointment->clinicDepartment->clinic->name }}</div>
            </td>

            <td>
                <div class="label">APPOINTMENT ID</div>
                <div class="value">#{{ $invoice->appointment_id }}</div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="label">PATIENT</div>
                <div class="value">{{ $invoice->patient->user->name }}</div>
            </td>

            <td>
                <div class="label">PAYMENT METHOD</div>
                <div class="value">{{ $invoice->payment_method }}</div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="label">DUE DATE</div>
                <div class="value">{{ $invoice->due_date ?? '-' }}</div>
            </td>

            <td>
                <div class="label">STATUS</div>
                <div class="value">{{ $invoice->payment_status }}</div>
            </td>
        </tr>
    </table>

    <!-- PAYMENT TABLE -->
    <table class="pay-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Consultation Fee</td>
                <td class="text-right">$ {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>

            <tr>
                <td><strong>Paid Amount</strong></td>
                <td class="text-right"><strong>$ {{ number_format($invoice->paid_amount, 2) }}</strong></td>
            </tr>

            <tr>
                <td><strong>Remaining</strong></td>
                <td class="text-right"><strong>$ {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- CREATED BY -->
    <div class="created">
        Created By <span>{{ $invoice->creator->user->name ?? 'Admin' }}</span>
    </div>


    @if($invoice->payment_status === 'Paid')
        <div class="signature">
            <p style="font-size: 13px; color:#6b7280;">Authorized Signature</p>
            <img src="{{ public_path('assets/img/signature/t3.png') }}">
        </div>
    @endif

</div>

</body>
</html>
