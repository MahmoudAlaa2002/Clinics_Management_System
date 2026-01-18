@extends('Backend.doctors.master')

@section('title', 'Medical Record Details')

@section('content')
    <style>
        body {
            background: #f6f9fc;
        }

        /* Adjust page wrapper to avoid being hidden behind fixed navbar */
        .page-wrapper {
            padding: 120px 15px 30px; /* top padding increased */
        }

        .page-title {
            color: #03A9F4;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .card-custom {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(3, 169, 244, 0.15);
        }

        .card-header-custom {
            padding: 15px 20px;
            font-weight: 700;
            color: #fff;
            font-size: 18px;
        }

        .card-body {
            padding: 20px;
        }

        .info-label {
            font-weight: 600;
            color: #03A9F4;
        }

        .info-value {
            color: #555;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
        }

        .status-pending { background-color: #ffc107; }
        .status-accepted { background-color: #189de4; }
        .status-rejected { background-color: #f90d25; }
        .status-cancelled { background-color: #6c757d; }
        .status-completed { background-color: #14ea6d; }

        .notes-box {
            background-color: #e3f2fd;
            border-left: 5px solid #03A9F4;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            color: #333;
            font-style: italic;
        }

        .prescriptions-box {
            background-color: #fff3e0;
            border-left: 5px solid #ff9800;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            color: #555;
        }

        .back-btn {
            background-color: #03A9F4;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(3, 169, 244, 0.2);
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #0288d1;
            box-shadow: 0 6px 18px rgba(2, 136, 209, 0.3);
            transform: translateY(-2px);
        }

        .back-btn,
        .back-btn:hover,
        .back-btn:focus,
        .back-btn:active {
            color: #fff !important;
        }

    </style>

    <div class="page-wrapper">

        {{-- Page Title --}}
        <h2 class="page-title">Medical Record Details</h2>

        {{-- Patient Info --}}
        <div class="card-custom">
            <div class="card-header-custom" style="background: linear-gradient(135deg, #03A9F4, #81D4FA);">
                Patient Information
            </div>
            <div class="card-body">
                <p><span class="info-label">Name:</span> <span class="info-value">{{ $medicalRecord->patient->user->name ?? '-' }}</span></p>
                <p><span class="info-label">Email:</span> <span class="info-value">{{ $medicalRecord->patient->user->email ?? '-' }}</span></p>
                <p><span class="info-label">Phone:</span> <span class="info-value">{{ $medicalRecord->patient->user->phone ?? '-' }}</span></p>
                <p><span class="info-label">Address:</span> <span class="info-value">{{ $medicalRecord->patient->user->address ?? '-' }}</span></p>
            </div>
        </div>

        {{-- Appointment Info --}}
        <div class="card-custom">
            <div class="card-header-custom" style="background: linear-gradient(135deg, #20c997, #45d08c);">
                Appointment Details
            </div>
            <div class="card-body">
                <p><span class="info-label">Appointment ID:</span> <span class="info-value">{{ $medicalRecord->appointment_id ?? '-' }}</span></p>
                <p><span class="info-label">Doctor:</span> <span class="info-value">{{ $medicalRecord->doctor->employee->user->name ?? '-' }}</span></p>
                <p><span class="info-label">Clinic:</span> <span class="info-value">{{ $medicalRecord->doctor->employee->clinic->name ?? '-' }}</span></p>
                <p><span class="info-label">Department:</span> <span class="info-value">{{ $medicalRecord->appointment->department->name ?? '-' }}</span></p>
                <p><span class="info-label">Date:</span> <span class="info-value">{{ \Carbon\Carbon::parse($medicalRecord->appointment->date ?? $medicalRecord->record_date)->format('Y-m-d') }}</span></p>
                <p><span class="info-label">Time:</span> <span class="info-value">{{ \Carbon\Carbon::parse($medicalRecord->appointment->time ?? '00:00')->format('H:i') }}</span></p>

                @php
                    $status = $medicalRecord->appointment->status ?? 'N/A';
                    $statusClass = strtolower($status);
                @endphp
                <p><span class="info-label">Status:</span> <span class="status-badge status-{{ $statusClass }}">{{ $status }}</span></p>

                @if ($status === 'Cancelled')
                    <div class="notes-box">
                        <strong>Cancellation Reason:</strong> {{ $medicalRecord->notes ?? 'N/A' }}
                    </div>
                @endif

                @if (!empty($medicalRecord->appointment->notes))
                    <div class="notes-box">
                        <strong>Appointment Note:</strong> {{ $medicalRecord->appointment->notes }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Medical Record Info --}}
        <div class="card-custom">
            <div class="card-header-custom" style="background: linear-gradient(135deg, #ff9800, #ffc107);">
                Medical Record Details
            </div>
            <div class="card-body">
                <p><span class="info-label">Diagnosis:</span> <span class="info-value">{{ $medicalRecord->diagnosis ?? '-' }}</span></p>
                <p><span class="info-label">Treatment:</span> <span class="info-value">{{ $medicalRecord->treatment ?? '-' }}</span></p>

                @if (!empty($medicalRecord->prescriptions))
                    <div class="prescriptions-box">
                        <strong>Prescriptions:</strong> {!! nl2br(e($medicalRecord->prescriptions)) !!}
                    </div>
                @endif

                @if (!empty($medicalRecord->attachmentss))
                    <div class="mt-3">
                        <strong>Attachments:</strong>
                        <ul>
                            @foreach (json_decode($medicalRecord->attachmentss, true) as $file)
                                <li>
                                    <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($medicalRecord->notes))
                    <div class="notes-box">
                        <strong>Medical Notes:</strong> {!! nl2br(e($medicalRecord->notes)) !!}
                    </div>
                @endif
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mt-4 d-flex justify-content-start">
            <a href="{{ route('doctor.medical_records') }}" class="btn back-btn">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
@endsection
