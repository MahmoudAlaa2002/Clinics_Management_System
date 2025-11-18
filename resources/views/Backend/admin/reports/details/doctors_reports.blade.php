@extends('Backend.admin.master')

@section('title', 'Doctors Reports (Preview)')

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

        <div class="report-header">
            <h3>Doctors Reports</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-user-md icon"></i>
                    <h5 class="fw-bold">Total Doctors</h5>
                    <h3 class="text-primary mb-0">{{ $doctors_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-check-circle icon"></i>
                    <h5 class="fw-bold">Active Doctors</h5>
                    <h3 class="text-success mb-0">{{ $active_doctors_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-ban icon"></i>
                    <h5 class="fw-bold">Inactive Doctors</h5>
                    <h3 class="text-danger mb-0">{{ $inactive_doctors_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-building icon"></i>
                    <h5 class="fw-bold">Departments</h5>
                    <h3 class="text-warning mb-0">{{ $department_count }}</h3>
                </div>
            </div>
        </div>

        <!-- Static Charts -->
        <div class="row">
            <!-- Monthly Chart -->
            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Doctors Registered Per Month</h5>
                    <canvas id="doctorsLineChart" height="200"></canvas>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Doctors Status Distribution</h5>
                    <canvas id="doctorStatusPieChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">🏥 Doctors by Department</h5>
                    <canvas id="departmentsBarChart" height="130"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    /* STATIC FAKE EXAMPLE DATA */

    fetch("{{ route('doctors_monthly') }}")
    .then(res => res.json())
    .then(data => {
        const ctx = document.getElementById('doctorsLineChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.months,
                datasets: [{
                    label: 'Doctors Registered',
                    data: data.counts,
                    borderColor: '#00A8FF',
                    fill: false,
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    pointRadius: 4,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });



    // Pie Chart
    new Chart(document.getElementById('doctorStatusPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $active_doctors_count }}, {{ $inactive_doctors_count }}],
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        }
    });


    fetch("{{ route('doctors_by_department') }}")
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('departmentsBarChart'), {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.counts,
                        backgroundColor: data.colors,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });


</script>

@endsection
