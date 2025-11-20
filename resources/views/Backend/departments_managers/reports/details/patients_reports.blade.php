@extends('Backend.departments_managers.master')

@section('title', 'Department Patients Reports')

@section('content')

<style>

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .report-header h4 {
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
            <h3>Clinic Patients Reports</h3>
        </div>

        <div class="row mb-4">

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-users icon"></i>
                    <h5 class="fw-bold">Total Patients</h5>
                    <h3 class="text-primary mb-0">{{ $patients_count }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-user-plus icon"></i>
                    <h5 class="fw-bold">New This Month</h5>
                    <h3 class="text-primary mb-0">{{ $patients_current_month }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-calendar-check icon"></i>
                    <h5 class="fw-bold">Completed Visits</h5>
                    <h3 class="text-primary mb-0">{{ $completed_visits }}</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-venus-mars icon"></i>
                    <h5 class="fw-bold">Gender Ratio</h5>
                    <h3 class="text-primary mb-0">{{ $male_percentage }}% ♂ / {{ $female_percentage }}% ♀</h3>
                </div>
            </div>

        </div>

        <!-- Charts -->
        <div class="row">

            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Monthly Patient Registrations</h5>
                    <canvas id="patientsLineChart" height="200"></canvas>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Gender Distribution</h5>
                    <canvas id="genderPieChart" height="200"></canvas>
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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>


    fetch("{{ route('department_patients_monthly') }}")
        .then(res => res.json())
        .then(data => {

            new Chart(document.getElementById('patientsLineChart'), {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Patients Registered',
                        data: data.counts,
                        borderColor: '#00A8FF',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: false,
                        pointRadius: 5
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

        })
        .catch(err => console.error("Chart Error:", err));


        new Chart(document.getElementById('genderPieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{ $male_patients_count }}, {{ $female_patients_count }}],
                    backgroundColor: ['#00A8FF', '#E83E8C'],
                    hoverOffset: 5
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });

</script>
@endsection
