@extends('Backend.doctors.master')

@section('title', 'Appointment Details')

@section('content')
<style>
    .appointment-wrapper {
        margin: 40px auto;
        max-width: 800px;
    }

    .appointment-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .appointment-title {
        font-size: 24px;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .detail-box {
        background-color: #f9f9f9;
        padding: 15px 20px;
        border-radius: 10px;
        border-left: 4px solid #007bff;
    }

    .detail-title {
        font-size: 12px;
        font-weight: 600;
        color: #666;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }

    .notes-section {
        background-color: #fff3cd;
        border-left: 5px solid #ffc107;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .notes-section h5 {
        font-size: 14px;
        font-weight: 600;
        color: #856404;
        margin-bottom: 6px;
    }

    .back-btn {
        background-color: #007bff;
        color: white;
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0056b3;
    }
</style>

<div class="page-wrapper">
    <div class="content appointment-wrapper">
        <div class="appointment-card">
            <div class="appointment-title">
                <i class="fas fa-calendar-check"></i> Appointment Details
            </div>

            <div class="details-grid">
                <div class="detail-box">
                    <div class="detail-title">Patient</div>
                    <div class="detail-value">{{ $appointment->patient->user->name }}</div>
                </div>

                <div class="detail-box">
                    <div class="detail-title">Clinic</div>
                    <div class="detail-value">{{ $appointment->clinic->name }}</div>
                </div>

                <div class="detail-box">
                    <div class="detail-title">Department</div>
                    <div class="detail-value">{{ $appointment->department->name }}</div>
                </div>

                <div class="detail-box">
                    <div class="detail-title">Date & Time</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}
                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </div>
                </div>
            </div>

            @if($appointment->notes)
                <div class="notes-section">
                    <h5>Notes</h5>
                    <p>{{ $appointment->notes }}</p>
                </div>
            @endif

            <div class="d-flex justify-content-end">
                <a href="{{ route('doctor.appointments') }}" class="btn back-btn">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
