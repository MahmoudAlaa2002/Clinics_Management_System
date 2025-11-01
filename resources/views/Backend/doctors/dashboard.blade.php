@extends('Backend.doctors.master')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg1"><i class="fas fa-calendar-alt"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $allAppointments }}</h3>
                        <span class="widget-title1">All Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fas fa-hourglass-half"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $pendingAppointments }}</h3>
                        <span class="widget-title2">Pending Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg3"><i class="fas fa-check-circle"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $completedAppointments }}</h3>
                        <span class="widget-title3">Completed <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg4"><i class="fas fa-user-injured"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $totalPatients }}</h3>
                        <span class="widget-title4">Total Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg1" style="background-color:#6f42c1;">
                        <i class="fas fa-calendar-day"></i>
                    </span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $todayAppointments }}</h3>
                        <span class="widget-title1" style="background-color:#6f42c1;">Today Appointments <i class="fa fa-check"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2" style="background-color:#198754;">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                    <div class="text-right dash-widget-info">
                        <h3>${{ number_format($monthlyErnings, 2) }}</h3>
                        <span class="widget-title2" style="background-color:#198754;">Monthly Earnings <i class="fa fa-check"></i></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Optional: You can add charts for appointments overview --}}
        <div class="row mt-4">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Appointments Overview</h4>
                            <span class="float-right"><i class="fa fa-caret-up"></i> This Month</span>
                        </div>
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Patients Growth</h4>
                            <span class="float-right"><i class="fa fa-caret-up"></i> Compared to Last Month</span>
                        </div>
                        <canvas id="patientsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
