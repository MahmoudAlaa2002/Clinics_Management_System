@extends('Backend.clinics_managers.master')

@section('title', 'Appointment Details')

@section('content')
<style>
    .appointment-wrapper {
        margin-top: 40px;
    }

    .appointment-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        transition: 0.3s;
    }

    .appointment-title {
        font-size: 26px;
        font-weight: 700;
        color: #03A9F4;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .appointment-title i {
        color: #03A9F4;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-box {
        background-color: #f8f9fa;
        padding: 20px 25px;
        border-radius: 12px;
        border-left: 5px solid #03A9F4;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    }

    .detail-box i {
        color: #03A9F4;
        font-size: 17px;
        margin-right: 8px;
    }

    .detail-title {
        font-size: 13px;
        font-weight: 600;
        color: #888;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .status-badge {
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
        margin-top: 5px;
    }

    .Scheduled { background-color: #03A9F4; color: white; }
    .Completed { background-color: #28C76F; color: white; }
    .Cancelled { background-color: #F44336; color: white; }

    .notes-section {
        background-color: #fff6e5;
        border-left: 5px solid #f9a825;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .notes-section h5 {
        color: #bf8500;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .back-btn {
        background-color: #03A9F4;
        color: white;
        border-radius: 50px;
        padding: 10px 30px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0288d1;
    }
</style>

<div class="page-wrapper">
    <div class="content appointment-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="appointment-card">

                    <div class="appointment-title">
                        <i class="fas fa-calendar-check"></i>
                        Appointment Details
                    </div>

                    <div class="details-grid">
                        <div class="detail-box">
                            <div class="detail-title"><i class="fas fa-user-injured"></i> Patient</div>
                            <div class="detail-value">{{ $appointment->patient->user->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-title"><i class="fa fa-hospital"></i> Clinic</div>
                            <div class="detail-value">{{ $appointment->clinicDepartment->clinic->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-title"><i class="fas fa-stethoscope"></i> Department</div>
                            <div class="detail-value">{{ $appointment->clinicDepartment->department->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-title"><i class="fas fa-user-md"></i> Doctor</div>
                            <div class="detail-value">{{ $appointment->doctor->employee->user->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-title"><i class="fas fa-calendar-day"></i> Date</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-title"><i class="fas fa-clock"></i> Time</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                        </div>

                    </div>

                    <div class="notes-section" style="background-color: #f2f2f2; border-left: 5px solid #b0b0b0; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                        <h5 style="color: #555; font-weight: bold;">
                            <i class="fas fa-sticky-note me-1" style="color: #888;"></i> Notes
                        </h5>
                        <p class="mb-0 text-muted">
                            {{ $appointment->notes ? $appointment->notes : 'No notes provided.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 d-flex justify-content-end" style="margin-right: 130px;">
        <a href="{{ Route('clinic.view_appointments') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
            Back
        </a>
    </div>
</div>
@endsection
