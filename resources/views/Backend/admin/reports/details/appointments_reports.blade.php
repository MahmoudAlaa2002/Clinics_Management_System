@extends('Backend.admin.master')

@section('title', 'Appointments Reports')

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
</style>

<div class="page-wrapper">
    <div class="content">

        <!-- Header -->
        <div class="report-header">
            <h3>Appointments Reports</h3>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-calendar-check icon"></i>
                    <h5 class="fw-bold">Total Appointments</h5>
                    <h3 class="text-primary mb-0">{{ $all_appointments }}</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-clock icon"></i>
                    <h5 class="fw-bold">Pending</h5>
                    <h3 class="text-warning mb-0">{{ $pending_appointments }}</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-user-md icon"></i>
                    <h5 class="fw-bold">Completed</h5>
                    <h3 class="text-success mb-0">{{ $completed_appointments }}</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card text-center p-3">
                    <i class="fas fa-times-circle icon"></i>
                    <h5 class="fw-bold">Cancelled</h5>
                    <h3 class="text-danger mb-0">{{ $cancelled_appointments }}</h3>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <!-- Monthly Appointments Line Chart -->
            <div class="col-lg-7 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📅 Monthly Completed Appointments</h5>
                    <canvas id="appointmentsLineChart" height="200"></canvas>
                </div>
            </div>

            <!-- Appointment Status Pie Chart -->
            <div class="col-lg-5 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">📊 Status Distribution</h5>
                    <canvas id="statusPieChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Chart -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="chart-card">
                    <h5 class="mb-3 text-muted">🏥 Appointments by Clinic</h5>
                    <canvas id="clinicBarChart" height="130"></canvas>
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
    // Line Chart - Monthly Appointments
    fetch("{{ route('appointments_monthly') }}")
            .then(res => res.json())
            .then(data => {
                const ctx1 = document.getElementById('appointmentsLineChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: data.months,
                        datasets: [{
                            label: 'Completed Appointments Per Month',
                            data: data.appointments,
                            borderColor: '#00A8FF',
                            backgroundColor: 'rgba(0,168,255,0.15)',
                            borderWidth: 3,
                            pointRadius: 4,
                            tension: 0.4
                        }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            });

    // Pie Chart - Appointment Status
    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [{{ $completed_appointments }}, {{ $pending_appointments }}, {{ $cancelled_appointments }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
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

    // Bar Chart - Appointments by Clinic
    fetch("{{ route('appointments_by_clinic') }}")
        .then(response => response.json())
        .then(data => {
            const labels = data.clinics.map(item => item.name);
            const counts = data.clinics.map(item => item.count);

            const ctxBar = document.getElementById('clinicBarChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Appointments',
                        data: counts,
                        backgroundColor: data.colors.slice(0, labels.length),
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Appointments';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Chart Error:', error));


</script>

@endsection
