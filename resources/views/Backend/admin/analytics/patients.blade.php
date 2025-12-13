@extends('Backend.admin.master')

@section('title', 'Patients Analytics')

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
</style>

<div class="page-wrapper">
    <div class="content">

        <div class="report-header">
            <h3>Patients Analytics</h3>
        </div>

        <div class="mb-4 row">
            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-users icon"></i>
                    <h5 class="fw-bold">Total Patients</h5>
                    <h3 class="mb-0 text-primary">{{ $patients_count }}</h3>
                </div>
            </div>
            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-user-plus icon"></i>
                    <h5 class="fw-bold">New This Month</h5>
                    <h3 class="mb-0 text-primary">{{ $currentMonthPatients }}</h3>
                </div>
            </div>
            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-calendar-check icon"></i>
                    <h5 class="fw-bold">Total Visits</h5>
                    <h3 class="mb-0 text-primary">{{ $completedVisits }}</h3>
                </div>
            </div>
            <div class="mb-3 col-md-3 col-sm-6">
                <div class="p-3 text-center stats-card">
                    <i class="fas fa-venus-mars icon"></i>
                    <h5 class="fw-bold">Gender Ratio</h5>
                    <h3 class="mb-0 text-primary">{{ $femalePercentage }}% ♂ / {{ $malePercentage }}% ♀</h3>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="mb-4 col-lg-7">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">🩺 Monthly Patient Registrations</h5>
                    <canvas id="patientsLineChart" height="200"></canvas>
                </div>
            </div>

            <div class="mb-4 col-lg-5">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Gender Distribution</h5>
                    <canvas id="genderPieChart" height="200"></canvas>
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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart (Patients per Month)
    fetch("{{ route('patients_monthly') }}")
        .then(response => response.json())
        .then(data => {

            const ctx1 = document.getElementById('patientsLineChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Patients Registered',
                        data: data.counts,
                        borderColor: '#00A8FF',
                        backgroundColor: 'rgba(0,168,255,0.2)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // حتى لا يظهر أرقام عشرية
                            }
                        }
                    }
                }
            });

        })
    .catch(error => console.error('Chart Error:', error));

    // Pie Chart (Gender Distribution)
    const ctx2 = document.getElementById('genderPieChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $malePercentage }}, {{ $femalePercentage }}],
                backgroundColor: ['#00A8FF', '#E83E8C'],
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection
