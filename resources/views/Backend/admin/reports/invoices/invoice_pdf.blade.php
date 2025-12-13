<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoices General Report</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 700px;
        margin: 40px auto;
        background: white;
        padding: 35px 45px;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        min-height: 930px;
    }
    h1 {
        text-align: center;
        color: #03A9F4;
        margin-bottom: 15px;
        font-size: 30px;
    }
    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 25px;
        color: #333;
        border-bottom: 2px solid #03A9F4;
        padding-bottom: 6px;
    }
    .item {
        margin: 8px 0;
        font-size: 15px;
        color: #2c3e50;
        line-height: 1.5;
    }
    .highlight {
        font-weight: bold;
        color: #03A9F4;
    }
    .page-break {
        page-break-after: always;
    }
</style>
</head>

<body>

<!--  ========================= PAGE 1 =========================  -->

<div class="container">

    <h1>Invoices General Report</h1>

    <div class="section-title">1. Overview</div>
    <p class="item">Total Invoices: <span class="highlight">{{ $total_invoices }}</span></p>
    <p class="item">Total Issued Invoices: <span class="highlight">{{ $total_issued_invoices }}</span></p>
    <p class="item">Total Cancelled Invoices: <span class="highlight">{{ $total_cancelled_invoices }}</span></p>
    <p class="item">Paid Invoices: <span class="highlight">{{ $paid_invoices }}</span></p>
    <p class="item">Unpaid Invoices: <span class="highlight">{{ $unpaid_invoices }}</span></p>
    <p class="item">Partially Paid Invoices: <span class="highlight">{{ $partially_paid }}</span></p>

    <div class="section-title">2. Today & Month Summary</div>
    <p class="item">Invoices Today: <span class="highlight">{{ $invoices_today }}</span></p>
    <p class="item">Invoices This Month: <span class="highlight">{{ $invoices_month }}</span></p>
    <p class="item">Average Daily Invoices: <span class="highlight">{{ number_format($avg_daily_invoices, 1) }}</span></p>

    <div class="section-title">3. Payment Methods Distribution</div>
    @foreach($paymentMethods as $method => $count)
        <p class="item">{{ $method }}: <span class="highlight">{{ $count }}</span></p>
    @endforeach

    <div class="section-title">4. Revenue Summary</div>
    <p class="item">Total Revenue: <span class="highlight">${{ number_format($total_revenue, 2) }}</span></p>
    <p class="item">Revenue This Month: <span class="highlight">${{ number_format($monthly_revenue, 2) }}</span></p>

</div>

<div class="page-break"></div>

<!--  ========================= PAGE 2 =========================  -->

<div class="container">

    <div class="section-title">5. Clinics Invoices Distribution</div>
    @foreach($clinicCounts as $clinic => $count)
        <p class="item">{{ $clinic }}: <span class="highlight">{{ $count }}</span> invoices</p>
    @endforeach

    <div class="section-title">6. Department Invoices Distribution</div>
    @foreach($departmentCounts as $dept => $count)
        <p class="item">{{ $dept }}: <span class="highlight">{{ $count }}</span> invoices</p>
    @endforeach

    <div class="section-title">7. Monthly Revenue Trend</div>
    @foreach($monthRevenue as $month => $total)
        <p class="item">Month {{ $month }}: <span class="highlight">${{ number_format($total, 2) }}</span></p>
    @endforeach

    <p class="item">
        Most Active Month:
        <span class="highlight">
            {{ $best_month ? "Month $best_month" : '-' }}
        </span>
    </p>

    <p class="item">
        Least Active Month:
        <span class="highlight">
            {{ $worst_month ? "Month $worst_month" : '-' }}
        </span>
    </p>


</div>

</body>
</html>
