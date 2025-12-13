@extends('Backend.clinics_managers.master')

@section('title', 'Clinic Invoices Reports')

@section('content')

<style>
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .report-header h3 {
        font-weight: 600;
    }

    .stats-card {
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.07);
        padding: 28px 15px !important;
        height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stats-card .icon {
        font-size: 40px !important;
        color: #00A8FF;
        margin-bottom: 12px;
    }

    .stats-card h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .stats-card h3 {
        font-size: 32px !important;
        font-weight: 700;
        margin: 0;
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    }

    .chart-card {
        border-radius: 12px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <!-- Header -->
        <div class="report-header">
            <h3>Invoices Reports</h3>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-file-invoice-dollar icon"></i>
                    <h5 class="fw-bold text-secondary">Total Invoices</h5>
                    <h3 class="text-primary mb-0">{{ $invoices_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fa fa-file-text-o icon"></i>
                    <h5 class="fw-bold text-secondary">Total Issued Invoices</h5>
                    <h3 class="text-primary mb-0">{{ $issued_invoices_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fa fa-file-excel-o icon"></i>
                    <h5 class="fw-bold text-secondary">Total cancelled Invoices</h5>
                    <h3 class="text-danger mb-0">{{ $cancelled_invoices_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-check-circle icon"></i>
                    <h5 class="fw-bold text-secondary">Paid</h5>
                    <h3 class="text-success mb-0">{{ $paid_invoices_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-exclamation-triangle icon"></i>
                    <h5 class="fw-bold text-secondary">Partially Paid</h5>
                    <h3 class="text-warning mb-0">{{ $partially_paid_invoices_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-times-circle icon"></i>
                    <h5 class="fw-bold text-secondary">Unpaid</h5>
                    <h3 class="text-danger mb-0">{{ $unpaid_invoices_count }}</h3>
                </div>
            </div>

        </div>

        <!-- Charts Section -->
        <div class="row">

            <!-- Monthly Revenue Line Chart -->
            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📈 Monthly Revenue Trend</h5>
                    <canvas id="revenueLineChart" height="200"></canvas>
                </div>
            </div>

            <!-- Payment Status Distribution -->
            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Payment Status Distribution</h5>
                    <canvas id="statusPieChart" height="200"></canvas>
                </div>
            </div>

        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('clinic.view_reports') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // Line Chart - Monthly Revenue
    fetch("{{ route('clinic_monthly_revenue') }}")
        .then(res => res.json())
        .then(data => {

            new Chart(document.getElementById('revenueLineChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Revenue ($)',
                        data: data.totals,
                        borderColor: '#00A8FF',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        pointRadius: 4,
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: { legend: { display: false }},
                    scales: { y: { beginAtZero: true }}
                }
            });
        });


    // Pie Chart - Invoice Status
    new Chart(document.getElementById('statusPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Partially Paid', 'Unpaid'],
            datasets: [{
                data: [{{ $paid_invoices_count }}, {{ $partially_paid_invoices_count }}, {{ $unpaid_invoices_count }}],
                backgroundColor: ['#28A745', '#FFC107', '#DC3545'],
                hoverOffset: 8
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' }}
        }
    });

</script>

@endsection
