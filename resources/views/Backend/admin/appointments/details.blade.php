@extends('Backend.admin.master')

@section('title', 'Appointment Details')

@section('content')

<style>
    .appointment-wrapper {
        margin-top: 40px;
    }

    .appointment-card {
        background: linear-gradient(135deg, #ffffff, #f4f9ff);
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        transition: 0.4s;
        border: 1px solid #e3f2fd;
    }

    .appointment-title {
        font-size: 30px;
        font-weight: 800;
        color: #039be5;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .appointment-title i {
        font-size: 32px;
        background: linear-gradient(135deg, #03A9F4, #0288d1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }

    .detail-box {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(6px);
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #e3f2fd;
        box-shadow: 0 6px 20px rgba(3, 169, 244, 0.08);
        position: relative;
        overflow: hidden;
        transition: 0.3s;
    }

    .detail-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(3, 169, 244, 0.18);
    }

    .detail-icon {
        font-size: 28px;
        color: #03A9F4;
        margin-bottom: 12px;
    }

    .detail-title {
        font-size: 13px;
        font-weight: 700;
        color: #777;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .detail-value {
        font-size: 17px;
        font-weight: 600;
        color: #222;
    }

    .notes-section {
        background: linear-gradient(135deg, #fffdf7, #fff3cd);
        border-left: 8px solid #ffb300;
        padding: 25px 30px;
        border-radius: 16px;
        margin-bottom: 35px;
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.15);
    }

    .notes-section h5 {
        color: #b87a00;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .back-btn {
        background: linear-gradient(135deg, #03A9F4, #0288d1);
        color: white;
        border-radius: 50px;
        padding: 12px 40px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0 6px 18px rgba(3, 169, 244, 0.3);
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #0288d1, #01579b);
        transform: translateY(-2px);
    }

    .status-pill {
        padding: 8px 22px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        display: inline-block;
        margin-top: 8px;
        letter-spacing: 0.5px;
    }

    .invoice-link {
        color: #000;          /* أسود افتراضي */
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .invoice-link:hover {
        color: #03A9F4;       /* أزرق عند المرور */
        text-decoration: none;
    }


</style>

<div class="page-wrapper">
    <div class="content appointment-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="appointment-card">

                    <div class="appointment-title">
                        <i class="fas fa-calendar-check"></i>
                        Appointment Details
                    </div>

                    <div class="details-grid">

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="detail-title">Appointment Number</div>
                            <div class="detail-value">{{ $appointment->id }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-user-injured"></i></div>
                            <div class="detail-title">Patient</div>
                            <div class="detail-value">{{ $appointment->patient->user->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fa fa-hospital"></i></div>
                            <div class="detail-title">Clinic</div>
                            <div class="detail-value">{{ $appointment->clinic->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-building"></i></div>
                            <div class="detail-title">Department</div>
                            <div class="detail-value">{{ $appointment->department->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-user-md"></i></div>
                            <div class="detail-title">Doctor</div>
                            <div class="detail-value">{{ $appointment->doctor->employee->user->name }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-calendar-day"></i></div>
                            <div class="detail-title">Date</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-clock"></i></div>
                            <div class="detail-title">Time</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-info-circle"></i></div>
                            <div class="detail-title">Status</div>
                                @if($appointment->status === 'Pending')
                                    <span class="status-pill" style="background-color:#ffc107; color:white;">
                                        Pending
                                    </span>

                                @elseif($appointment->status === 'Accepted')
                                    <span class="status-pill" style="background-color:#189de4; color:white;">
                                        Accepted
                                    </span>

                                @elseif($appointment->status === 'Rejected')
                                    <span class="status-pill" style="background-color:#f90d25; color:white;">
                                        Rejected
                                    </span>

                                @elseif($appointment->status === 'Cancelled')
                                    <span class="status-pill" style="background-color:#6c757d; color:white;">
                                        Cancelled
                                    </span>

                                @elseif($appointment->status === 'Completed')
                                    <span class="status-pill" style="background-color:#14ea6d; color:white;">
                                        Completed
                                    </span>
                                @endif
                        </div>

                        <div class="detail-box">
                            <div class="detail-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            <div class="detail-title">Appointment Invoice</div>
                            <div class="detail-value">
                                @if($appointment->invoice)
                                    <a href="{{ route('details_invoice', ['id' => $appointment->invoice->id]) }}"
                                    class="invoice-link">
                                        Invoice View
                                    </a>
                                @else
                                    <span class="text-muted">No Invoice</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="notes-section">
                        <h5><i class="fas fa-sticky-note me-1"></i> Notes</h5>
                        <p class="mb-0">
                            {{ $appointment->notes ? $appointment->notes : 'No notes provided.' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 d-flex justify-content-end" style="margin-right: 80px;">
        <a href="{{ Route('view_appointments') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
            Back
        </a>
    </div>
</div>
@endsection
