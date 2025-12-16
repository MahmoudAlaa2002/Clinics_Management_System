@extends('Backend.employees.nurses.master')

@section('title', 'Medical Record Details')

@section('content')

<style>
    .mr-header-card {
        background: linear-gradient(135deg, #00A8FF, #0087cc);
        color: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .mr-header-card h4 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }
    .mr-header-details {
        font-size: 14px;
        margin-top: 5px;
        line-height: 1.6rem;
    }

    .mr-card {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        border-left: 6px solid #00A8FF;
        margin-bottom: 30px;
    }
    .mr-title {
        font-weight: 700;
        font-size: 20px;
        color: #00A8FF;
        border-bottom: 2px solid #e5e5e5;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }
    .mr-box {
        background: #fafafa;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        border: 1px solid #e6e6e6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: 0.3s ease-in-out;
    }
    .mr-box:hover {
        transform: translateY(-5px);
    }
    .mr-box h6 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #333;
    }
    .mr-box p {
        font-size: 18px;
        font-weight: 700;
        color: #00A8FF;
        margin: 0;
    }
    .mr-icon {
        font-size: 28px;
        color: #00A8FF;
        margin-bottom: 6px;
    }

    .notes-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #00A8FF;
        display: flex;
        align-items: center;
    }
    .notes-title i {
        margin-right: 8px;
        font-size: 22px;
        color: #00A8FF;
    }
</style>


<div class="page-wrapper">
    <div class="content">

        <!-- Header -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="mr-header-card">
                    <div class="mr-header-details">
                        Appointment: <strong>#{{ $medical_record->appointment_id }}</strong><br>
                        Patient: <strong>{{ $medical_record->patient->user->name }}</strong><br>
                        Doctor: <strong>Dr. {{ $medical_record->doctor->employee->user->name }}</strong><br>
                        Record Date: <strong>{{ \Carbon\Carbon::parse($medical_record->record_date)->format('d M Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Record Details -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="mr-card">
                    <div class="d-flex justify-content-between align-items-center mr-title">
                        <span>Medical Record Overview</span>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mr-box text-center">
                                <i class="fas fa-diagnoses mr-icon"></i>
                                <h6>Diagnosis</h6>
                                <p>{{ $medical_record->diagnosis ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mr-box text-center">
                                <i class="fas fa-pills mr-icon"></i>
                                <h6>Treatment</h6>
                                <p>{{ $medical_record->treatment ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mr-box text-center">
                                <i class="fas fa-notes-medical mr-icon"></i>
                                <h6>Prescriptions</h6>
                                <p>{{ $medical_record->prescriptions ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mr-box text-center">
                                <i class="fas fa-paperclip mr-icon"></i>
                                <h6>Attachments</h6>
                                <p>{{ $medical_record->attachments ?? '-' }}</p>
                            </div>
                        </div>

                    </div>

                    @if($medical_record->notes)
                        <div class="mt-4">
                            <div class="notes-box p-3">
                                <h6 class="notes-title">
                                    <i class="fas fa-sticky-note"></i> Notes
                                </h6>
                                <p class="notes-text" style="font-size:16px; color:#444;">
                                    {{ $medical_record->notes }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-right">
                <a href="{{ route('nurse.view_medical_records') }}"
                   class="btn btn-primary rounded-pill px-4 py-2" style="font-weight: bold;">
                    Back
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
