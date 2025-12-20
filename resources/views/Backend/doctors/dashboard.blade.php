@extends('Backend.doctors.master')

@section('title', 'Doctor Dashboard')

@section('content')

    <style>
        .dash-widget span[class^="dash-widget-bg"] {
            display: flex !important;
            justify-content: center;
            align-items: center;
            font-size: 30px;       /* حجم الأيقونة */
            width: 60px;           /* قطر الدائرة */
            height: 60px;          /* قطر الدائرة */
            border-radius: 50%;
        }

        .welcome-card {
            background: linear-gradient(135deg, #00A8FF, #00A8FF);
            border-radius: 18px;
            padding: 0;
            overflow: hidden;
            position: relative;
            box-shadow: 0 12px 28px rgba(0, 128, 255, 0.25);
            transition: 0.35s ease-in-out;
            width: 100%;
        }

        .welcome-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 32px rgba(0, 128, 255, 0.35);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            filter: blur(40px);
        }

        .welcome-content {
            display: flex;
            align-items: center;
            padding: 28px 32px;
            position: relative;
            z-index: 10;
        }

        .welcome-icon {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-right: 20px;
            backdrop-filter: blur(6px);
            border: 2px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            animation: pulseGlow 2.3s infinite ease-in-out;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
            50% { box-shadow: 0 0 22px rgba(255,255,255,0.9); }
            100% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
        }

        .welcome-text h3 {
            margin: 0;
            color: #ffffff;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: .5px;
        }

        .welcome-text p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            font-weight: 400;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">

            {{-- Welcome --}}
            <div class="row">
                <div class="col-12 mb-4 mt-2">
                    <div class="welcome-card">
                        <div class="welcome-content">

                            <div class="welcome-icon">
                                <i class="fas fa-handshake"></i>
                            </div>

                            <div class="welcome-text">
                                <h3>Welcome, {{ Auth::user()->name }} 👋</h3>
                                <p>We hope you have a productive and wonderful day!</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- All Appointments -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1" style="background-color:#189de4;"><!-- Accepted / General Blue -->
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $allAppointments }}</h3>
                            <span class="widget-title1" style="background-color:#189de4;">All Appointments <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2" style="background-color:#ffc107;"><!-- Pending -->
                            <i class="fas fa-hourglass-half"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $pendingAppointments }}</h3>
                            <span class="widget-title2" style="background-color:#ffc107;">Pending Appointments <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Completed Appointments -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg3" style="background-color:#14ea6d;"><!-- Completed -->
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $completedAppointments }}</h3>
                            <span class="widget-title3" style="background-color:#14ea6d;">Completed <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Total Patients -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4" style="background-color:#6c757d;"><!-- Cancelled / Grey -->
                            <i class="fas fa-user-injured"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $totalPatients }}</h3>
                            <span class="widget-title4" style="background-color:#6c757d;">Total Patients <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Today Appointments -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1" style="background-color:#189de4;">
                            <i class="fas fa-calendar-day"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $todayAppointments }}</h3>
                            <span class="widget-title1" style="background-color:#189de4;">Today Appointments <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Monthly Earnings -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2" style="background-color:#198754;"><!-- Dark Green -->
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>${{ number_format($monthlyEarnings, 2) }}</h3>
                            <span class="widget-title2" style="background-color:#198754;">Monthly Earnings <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Total Earnings -->
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2" style="background-color:#28a745;">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>${{ number_format($totalEarnings, 2) }}</h3>
                            <span class="widget-title2" style="background-color:#28a745;">Total Earnings <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="row mt-4">
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Appointments Overview (Last 6 Months)</h5>
                            <div style="height:300px;">
                                <canvas id="appointmentsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Completed, Cancelled, Pending, Accepted</h5>
                            <div style="height:300px;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = @json($months);
        const appointmentsData = @json($appointmentsPerMonth);
        const completedData = @json($completedPerMonth);
        const cancelledData = @json($cancelledPerMonth);
        const pendingData = @json($pendingPerMonth);
        const acceptedData = @json($acceptedPerMonth);

        // Appointments Overview Chart
        new Chart(document.getElementById('appointmentsChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Appointments',
                    data: appointmentsData,
                    borderColor: 'rgba(3, 169, 244, 1)',
                    backgroundColor: 'rgba(3, 169, 244, 0.2)',
                    fill: true,
                    tension: 0.3
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

        // Completed vs Cancelled Chart
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                        label: 'Completed',
                        data: completedData,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)'
                    },
                    {
                        label: 'Cancelled',
                        data: cancelledData,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)'
                    },
                    {
                        label: 'Pending',
                        data: pendingData,
                        backgroundColor: 'rgba(225, 193, 7, 0.7)'
                    },
                    {
                        label: 'Accepted',
                        data: acceptedData,
                        backgroundColor: 'rgba(24, 157, 228, 0.7)'
                    }
                ]
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
    </script>
@endsection
