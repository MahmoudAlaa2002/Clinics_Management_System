@extends('Backend.admin.master')

@section('title', 'Medical Record Details')

@section('content')

<style>
    .record-wrapper {
        margin-top: 50px;
    }

    .record-card {
        background: linear-gradient(135deg, #ffffff, #eef6ff);
        border-radius: 25px;
        padding: 60px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
        border: 1px solid #dbeafe;
        position: relative;
        overflow: hidden;
    }

    .record-card::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, #03A9F4, transparent 70%);
        opacity: 0.15;
    }

    .record-title {
        font-size: 34px;
        font-weight: 900;
        color: #03A9F4;
        margin-bottom: 45px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .record-title i {
        font-size: 36px;
        background: linear-gradient(135deg, #03A9F4, #03A9F4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 30px;
        margin-bottom: 45px;
    }

    .detail-box {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        padding: 26px;
        border-radius: 18px;
        border: 1px solid #e0f2fe;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.12);
        transition: all 0.35s ease;
        position: relative;
    }

    .detail-box:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 18px 40px rgba(3, 169, 244, 0.25);
    }

    .detail-icon {
        position: absolute;
        top: -18px;
        right: 18px;
        font-size: 28px;
        color: white;
        background: linear-gradient(135deg, #03A9F4, #03A9F4);
        padding: 12px;
        border-radius: 14px;
        box-shadow: 0 8px 18px rgba(3, 169, 244, 0.35);
    }

    .detail-title {
        font-size: 13px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .section-box {
        background: linear-gradient(135deg, #f8fbff, #edf5ff);
        border-left: 8px solid #03A9F4;
        padding: 28px 30px;
        border-radius: 18px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(3, 169, 244, 0.12);
    }

    .section-box h4 {
        font-weight: 900;
        color: #03A9F4;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-box p {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0;
    }

    .back-btn {
        background: linear-gradient(135deg, #03A9F4, #03A9F4);
        color: white;
        border-radius: 50px;
        padding: 14px 45px;
        font-weight: 800;
        font-size: 15px;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(3, 169, 244, 0.35);
        transition: 0.3s;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #03A9F4, #03A9F4);
        transform: translateY(-3px);
    }
</style>

<div class="page-wrapper">
    <div class="content record-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="record-card">

                    <div class="record-title">
                        <i class="fas fa-notes-medical"></i>
                        Medical Record Details
                    </div>

                    <div class="details-grid">

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-hashtag"></i></div>
                            <div class="detail-title">Record ID</div>
                            <div class="detail-value">{{ $medical_record->id }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-user-injured"></i></div>
                            <div class="detail-title">Patient</div>
                            <div class="detail-value">{{ $medical_record->appointment->patient->user->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-hospital"></i></div>
                            <div class="detail-title">Clinic</div>
                            <div class="detail-value">{{ $medical_record->appointment->clinicDepartment->clinic->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="detail-title">Department</div>
                            <div class="detail-value">{{ $medical_record->appointment->clinicDepartment->department->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-user-md"></i></div>
                            <div class="detail-title">Doctor</div>
                            <div class="detail-value">{{ $medical_record->appointment->doctor->employee->user->name }}</div>
                        </div>


                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-calendar-day"></i></div>
                            <div class="detail-title">Record Date</div>
                            <div class="detail-value">{{ $medical_record->record_date }}</div>
                        </div>

                    </div>

                    <div class="section-box">
                        <h4><i class="fas fa-diagnoses"></i> Diagnosis</h4>
                        <p>{{ $medical_record->diagnosis }}</p>
                    </div>

                    <div class="section-box">
                        <h4><i class="fas fa-prescription-bottle-medical"></i> Treatment</h4>
                        <p>{{ $medical_record->treatment }}</p>
                    </div>

                    <div class="section-box">
                        <h4><i class="fas fa-pills"></i> Prescriptions</h4>
                        <p>{{ $medical_record->prescriptions }}</p>
                    </div>

                    <div class="section-box">
                        <h4><i class="fas fa-paperclip"></i> Attachments</h4>
                        <p>{{ $medical_record->attachments }}</p>
                    </div>

                    <div class="section-box">
                        <h4><i class="fas fa-sticky-note"></i> Notes</h4>
                        <p>{{ $medical_record->notes }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 d-flex justify-content-end" style="margin-right: 85px;">
        <a href="{{ Route('view_medical_records') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
            Back
        </a>
    </div>

</div>

@endsection
