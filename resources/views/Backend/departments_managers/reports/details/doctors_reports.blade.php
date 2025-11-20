@extends('Backend.departments_managers.master')

@section('title', 'Department Doctors Reports')

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
                    <h3 class="text-primary mb-0">{{ $doctor_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-award icon"></i>
                    <h5 class="fw-bold">Top Doctors</h5>
                    <h3 class="text-warning mb-0">{{ $top_doctors_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-check-circle icon"></i>
                    <h5 class="fw-bold">Active Doctors</h5>
                    <h3 class="text-success mb-0">{{ $active_doctor_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-ban icon"></i>
                    <h5 class="fw-bold">Inactive Doctors</h5>
                    <h3 class="text-danger mb-0">{{ $inactive_doctor_count }}</h3>
                </div>
            </div>

        </div>

        <!-- Charts -->
        <div class="row">

            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Doctors Registered Per Month</h5>
                    <canvas id="doctorsLineChart" height="200"></canvas>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Doctors Status Distribution</h5>
                    <canvas id="doctorStatusPieChart" height="200"></canvas>
                </div>
            </div>

        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('department.view_reports') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">Back</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    fetch("{{ route('department_doctors_monthly') }}")
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('doctorsLineChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Doctors Registered',
                        data: data.counts,
                        borderColor: '#00A8FF',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        pointRadius: 4,
                        tension: 0.4
                    }]
                }
            });
        });


    new Chart(document.getElementById('doctorStatusPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $active_doctor_count }} , {{ $inactive_doctor_count }}],
                backgroundColor: ['#28a745', '#dc3545'],
                hoverOffset: 6
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });

</script>

@endsection
