@extends('Backend.doctors.master')

@section('title', 'Nurse Task Details')

@section('content')

<style>
    .nt-header-card {
        background: linear-gradient(135deg, #00A8FF, #00A8FF);
        color: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .nt-card {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        border-left: 6px solid #00A8FF;
        margin-bottom: 30px;
    }

    .nt-title {
        font-weight: 700;
        font-size: 20px;
        color: #00A8FF;
        border-bottom: 2px solid #e5e5e5;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }

    .nt-box {
        background: #fafafa;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        border: 1px solid #e6e6e6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: 0.3s ease-in-out;
        text-align: center;
    }

    .nt-box:hover {
        transform: translateY(-5px);
    }

    .nt-box h6 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #333;
    }

    .nt-box p {
        font-size: 18px;
        font-weight: 700;
        color: #00A8FF;
        margin: 0;
    }

    .nt-icon {
        font-size: 28px;
        color: #00A8FF;
        margin-bottom: 6px;
    }

    .nt-notes-box {
        background: #f9fbff;
        border-radius: 14px;
        padding: 22px;
        border: 1px solid #dbeafe;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-top: 30px;
    }

    .nt-notes-title {
        font-size: 20px;
        font-weight: 700;
        color: #00A8FF;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nt-notes-text {
        font-size: 16px;
        color: #444;
        line-height: 1.8;
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        border: 1px dashed #cfe3ff;
    }

    .nt-status {
        font-size: 18px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 30px;
        display: inline-block;
        min-width: 130px;
        text-align: center;
    }

    .status-completed {
        color: #14ea6d !important;
    }

    .status-pending {
        color: #ffc107 !important;
    }

</style>

<div class="page-wrapper">
    <div class="content">

        <!-- Header -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="nt-header-card">
                    Appointment: #<strong>{{ $task->appointment_id }}</strong><br>
                    Nurse: <strong>{{ $task->nurse->user->name }}</strong><br>
                </div>
            </div>
        </div>

        <!-- Task Details -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="nt-card">
                    <div class="nt-title">
                        Nurse Task Overview
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="nt-box">
                                <i class="fas fa-user-injured nt-icon"></i>
                                <h6>Patient Name</h6>
                                <p>{{ $task->appointment->patient->user->name }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="nt-box">
                                <i class="fas fa-tasks nt-icon"></i>
                                <h6>Task</h6>
                                <p>{{ $task->task }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="nt-box">
                                <i class="fas fa-calendar-alt nt-icon"></i>
                                <h6>Performed At</h6>
                                <p>
                                    {{ $task->performed_at
                                        ? \Carbon\Carbon::parse($task->performed_at)->format('d M Y')
                                        : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="nt-box">
                                <i class="fas fa-info-circle nt-icon"></i>
                                <h6>Status</h6>
                                <p class="nt-status {{ $task->status === 'Completed' ? 'status-completed' : 'status-pending' }}">
                                    {{ $task->status }}
                                </p>
                            </div>
                        </div>

                    </div>


                    <div class="nt-notes-box">
                        <div class="nt-notes-title">
                            <i class="fas fa-sticky-note"></i> Notes
                        </div>

                        <div class="nt-notes-text">
                            @if($task->notes)
                                {{ $task->notes }}
                            @else
                                <span style="color:#888;">No Notes Provided</span>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                    Back
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
