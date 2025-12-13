@extends('Backend.admin.master')

@section('title', 'Employees Analytics')

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
            <h3>Employees Analytics</h3>
        </div>

        <div class="mb-4 row">
            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-users icon"></i>
                    <h5 class="fw-bold">Total Employees</h5>
                    <h3 class="mb-0 text-primary">{{ $employees_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-hospital-user icon"></i>
                    <h5 class="fw-bold">Total Clinics Managers</h5>
                    <h3 class="mb-0 text-primary">{{ $clinics_managers_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-cog icon"></i>
                    <h5 class="fw-bold">Total Departments Managers</h5>
                    <h3 class="mb-0 text-primary">{{ $departments_managers_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-md icon"></i>
                    <h5 class="fw-bold">Total Doctors</h5>
                    <h3 class="mb-0 text-primary">{{ $doctors_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-nurse icon"></i>
                    <h5 class="fw-bold">Total Nurses</h5>
                    <h3 class="mb-0 text-primary">{{ $nurses_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-headset icon"></i>
                    <h5 class="fw-bold">Total Receptionists</h5>
                    <h3 class="mb-0 text-primary">{{ $receptionists_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fa fa-money icon"></i>
                    <h5 class="fw-bold">Total Accountants</h5>
                    <h3 class="mb-0 text-primary">{{ $accountants_count }}</h3>
                </div>
            </div>

            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-check icon"></i>
                    <h5 class="fw-bold">Active Employees</h5>
                    <h3 class="mb-0 text-success">{{ $active_employees_count }}</h3>
                </div>
            </div>


            {{-- <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-slash icon"></i>
                    <h5 class="fw-bold">Inactive Employees</h5>
                    <h3 class="mb-0 text-danger">{{ $inactive_employees_count }}</h3>
                </div>
            </div> --}}

        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="mb-4 col-lg-7">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Employees Joined Per Month</h5>
                    <canvas id="employeesLineChart" height="200"></canvas>
                </div>
            </div>

            <div class="mb-4 col-lg-5">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Employees Status Distribution</h5>
                    <canvas id="employeesPieChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    fetch("{{ route('employees_monthly') }}")
        .then(response => response.json())
        .then(data => {

            new Chart(document.getElementById('employeesLineChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Employees Joined',
                        data: data.counts,
                        borderColor: '#00A8FF',
                        borderWidth: 3,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        })
    .catch(error => console.error(error));


    // Fake Static Pie Chart
    new Chart(document.getElementById('employeesPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $active_employees_count }}, {{ $inactive_employees_count }}],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        }
    });


</script>

@endsection
