@extends('Backend.departments_managers.master')

@section('title', 'Reports Dashboard')

@section('content')

<style>
    .report-card {
        transition: all 0.25s ease-in-out;
        border-radius: 10px;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    .report-card .btn {
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .report-card .btn-outline-danger:hover {
        background-color: #E83E8C !important;
        border-color: #E83E8C !important;
        color: #fff !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 style="font-weight: 600; color:#00A8FF;">📊 Reports </h3>
                <p class="text-muted">Select a report to view detailed statistics and insights</p>
            </div>
        </div>

        <div class="row">

            <!-- Patients Report -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card report-card text-center shadow-sm" style="border-top: 5px solid #00A8FF;">
                    <div class="card-body">
                        <i class="fas fa-user-injured fa-3x mb-3" style="color:#00A8FF;"></i>
                        <h5 class="card-title">Patients Reports</h5>
                        <p class="card-text text-muted">View statistics about registered patients and visits per month.</p>
                        <a href="{{ route('department.details_patients_reports') }}" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Doctors Report -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card report-card text-center shadow-sm" style="border-top: 5px solid #28A745;">
                    <div class="card-body">
                        <i class="fas fa-user-md fa-3x mb-3" style="color:#28A745;"></i>
                        <h5 class="card-title">Doctors Performance</h5>
                        <p class="card-text text-muted">Monitor doctor activities, patient feedback, and appointment counts.</p>
                        <a href="{{ route('department.details_doctors_reports') }}" class="btn btn-outline-success">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Appointments Report -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card report-card text-center shadow-sm" style="border-top: 5px solid #E83E8C;">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-3x mb-3" style="color:#E83E8C;"></i>
                        <h5 class="card-title">Appointments Reports</h5>
                        <p class="card-text text-muted">Analyze appointments by clinic, doctor, and completion status.</p>
                        <a href="{{ route('department.details_appointments_reports') }}" class="btn btn-outline-danger">View Details</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
