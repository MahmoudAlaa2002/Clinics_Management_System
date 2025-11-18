@extends('Backend.admin.master')

@section('title', 'Invoices Reports')

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
        padding: 28px 15px !important; /* ← أعلى وأسفل أكبر – يمين ويسار أقل */
        height: 150px; /* ← زوّدنا الارتفاع */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* تكبير الأيقونة */
    .stats-card .icon {
        font-size: 40px !important; /* ← كان 28 */
        color: #00A8FF;
        margin-bottom: 12px;
    }

    /* العنوان */
    .stats-card h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    /* الرقم */
    .stats-card h3 {
        font-size: 32px !important; /* ← تكبير الرقم */
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

    .badge-status {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 50px;
        font-weight: 600;
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
                    <i class="fas fa-check-circle icon"></i>
                    <h5 class="fw-bold text-secondary">Paid</h5>
                    <h3 class="text-success mb-0">{{ $paid_invoices }}</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-exclamation-triangle icon"></i>
                    <h5 class="fw-bold text-secondary">Partially Paid</h5>
                    <h3 class="text-warning mb-0">{{ $partially_paid_invoices }}</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-times-circle icon"></i>
                    <h5 class="fw-bold text-secondary">Unpaid</h5>
                    <h3 class="text-danger mb-0">{{ $unpaid_invoices }}</h3>
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

        <!-- Revenue by Clinic -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">🏥 Revenue by Clinic</h5>
                    <canvas id="clinicRevenueChart" height="130"></canvas>
                </div>
            </div>
        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('view_reports') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart - Monthly Revenue
    fetch("{{ route('monthly_revenue') }}")
    .then(res => res.json())
    .then(data => {

        const ctxLine = document.getElementById('revenueLineChart').getContext('2d');

        const gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0,168,255,0.35)');
        gradient.addColorStop(1, 'rgba(0,168,255,0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: data.months,  // ← نفس اللي كان بالثابت
                datasets: [{
                    label: 'Revenue ($)',
                    data: data.totals.map(v => Number(v)),  // ← بدّلنا فقط الأرقام
                    borderColor: '#00A8FF',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#00A8FF'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

    });

    // Pie Chart - Payment Status
    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Partially Paid' , 'Paid' , 'Unpaid'],
            datasets: [{
                data: [{{ $partially_paid_invoices }} , {{ $paid_invoices }} , {{ $unpaid_invoices }}],
                backgroundColor: ['#FFC107' , '#28A745' , '#DC3545'],
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Bar Chart - Revenue by Clinic
    fetch("{{ route('revenue_per_clinic') }}")
    .then(res => res.json())
    .then(data => {

        const ctx = document.getElementById('clinicRevenueChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.clinics,
                datasets: [{
                    label: 'Revenue ($)',
                    data: data.totals,
                    backgroundColor: 'rgba(0,168,255,0.5)',
                    borderColor: '#00A8FF',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }},
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

    });

</script>

@endsection
