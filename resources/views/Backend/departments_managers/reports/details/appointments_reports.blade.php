@extends('Backend.departments_managers.master')

@section('title', 'Department Appointments Reports')

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
            <h3>Department Appointments Reports</h3>
        </div>

        <div class="row mb-4">

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-calendar-check icon"></i>
                    <h5 class="fw-bold">Total Appointments</h5>
                    <h3 class="text-primary mb-0">{{ $appointments_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-clock icon"></i>
                    <h5 class="fw-bold">Pending</h5>
                    <h3 class="text-warning mb-0">{{ $pending_appointments_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-user-md icon"></i>
                    <h5 class="fw-bold">Completed</h5>
                    <h3 class="text-success mb-0">{{ $completed_appointments_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-times-circle icon"></i>
                    <h5 class="fw-bold">Cancelled</h5>
                    <h3 class="text-danger mb-0">{{ $cancelled_appointments_count }}</h3>
                </div>
            </div>

        </div>

        <!-- Charts -->
        <div class="row">

            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Monthly Completed Appointments</h5>
                    <canvas id="appointmentsLineChart" height="200"></canvas>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Status Distribution</h5>
                    <canvas id="statusPieChart" height="200"></canvas>
                </div>
            </div>

        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('department.view_reports') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // Line Chart - Monthly Appointments
    fetch("{{ route('department_manager.appointments_per_month') }}")
        .then(res => res.json())
        .then(data => {

            new Chart(document.getElementById('appointmentsLineChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Appointments Per Month',
                        data: data.counts,
                        borderColor: '#00A8FF',
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


    // Pie Chart - Appointment Status
    new Chart(document.getElementById('statusPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Completed', 'Cancelled'],
            datasets: [{
                data: [{{ $pending_appointments_count }}, {{ $completed_appointments_count }}, {{ $cancelled_appointments_count }}],
                backgroundColor: ['#ffc107' , '#28a745' , '#dc3545'],
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

</script>

@endsection
