@extends('Backend.patients.master')

@section('title', 'My Statistics')

@section('content')

    <style>
        .status-badge {
            min-width: 140px;
            text-align: center;
            padding: 4px 12px;
            font-size: 16px;
            border-radius: 50px;
            color: white;
            font-weight: 500;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-accepted {
            background-color: #189de4;
        }

        .status-rejected {
            background-color: #f90d25;
        }

        .status-cancelled {
            background-color: #6c757d;
        }

        .status-completed {
            background-color: #14ea6d;
        }
    </style>


    <div class="page-wrapper">
        <div class="content">

            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="page-title">My Statistics</h4>
                </div>
            </div>

            <div class="row">
                {{-- All Appointments --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1" style="background-color:#28a745;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $patientAppointments->count() }}</h3>
                            <span class="widget-title1" style="background-color:#28a745;">All Appointments <i
                                    class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Upcoming Appointments --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1" style="background-color:#189de4;">
                            <i class="fas fa-calendar-check"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $upCamingAppointments->count() }}</h3>
                            <span class="widget-title1" style="background-color:#189de4;">Upcoming Appointments <i
                                    class="fa fa-hourglass-start"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Completed Appointments --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2" style="background-color:#14ea6d;">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $completedAppointments }}</h3>
                            <span class="widget-title2" style="background-color:#14ea6d;">Completed Appointments <i
                                    class="fa fa-check-circle"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Medical Records --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg3" style="background-color:#ffc107;">
                            <i class="fas fa-notes-medical"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>{{ $recordsCount }}</h3>
                            <span class="widget-title3" style="background-color:#ffc107;">Medical Records <i
                                    class="fa fa-notes-medical"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Total Paid Amount --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4" style="background-color:#28a745;">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3>${{ number_format($totalAmount, 2) }}</h3>
                            <span class="widget-title4" style="background-color:#28a745;">Total Paid <i
                                    class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Total UnPaid Amount --}}
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4" style="background-color:#dc3545;">
                            <i class="fas fa-dollar-sign" style="color: #ffffff;"></i>
                        </span>
                        <div class="text-right dash-widget-info">
                            <h3 style="color: #dc3545; font-weight: 700;">${{ number_format($totalUnpaidAmount, 2) }}</h3>
                            <span class="widget-title4"
                                style="background-color:#f8d7da; color:#721c24; padding: 5px 10px; border-radius: 5px;">
                                Total Unpaid <i class="fa fa-exclamation-circle"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Optional: Table of Upcoming Appointments --}}
            @if ($upCamingAppointments->count())
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Upcoming Appointments</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Clinic</th>
                                                <th>Department</th>
                                                <th>Doctor</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($upCamingAppointments as $appointment)
                                                <tr>
                                                    @php
                                                        $date = \Carbon\Carbon::parse($appointment->date);
                                                        $isToday = $date->isToday();
                                                    @endphp
                                                    <td>
                                                        @if ($isToday)
                                                            Today
                                                        @else
                                                            {{ $date->format('d/m/Y') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                                    </td>
                                                    <td>{{ $appointment->doctor->employee->clinic->name ?? '-' }}</td>
                                                    <td>{{ $appointment->doctor->employee->department->name ?? '-' }}</td>
                                                    <td>{{ $appointment->doctor->employee->user->name ?? '-' }}</td>
                                                    <td>
                                                        <span
                                                            class="status-badge
                                                            @if ($appointment->status === 'Pending') status-pending
                                                            @elseif($appointment->status === 'Accepted') status-accepted
                                                            @elseif($appointment->status === 'Rejected') status-rejected
                                                            @elseif($appointment->status === 'Cancelled') status-cancelled
                                                            @elseif($appointment->status === 'Completed') status-completed @endif">
                                                            {{ $appointment->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
