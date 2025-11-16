@extends('Backend.doctors.master')

@section('title', 'Patient Profile')

@section('content')

    <style>
        .profile-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #03A9F4;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #03A9F4;
            padding-bottom: 5px;
        }

        .table-borderless th {
            width: 180px;
            text-align: left;
        }

        .table-borderless td {
            text-align: left;
        }

        .back-btn {
            background-color: #03A9F4;
            color: white;
            border-radius: 30px;
            padding: 10px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(3, 169, 244, 0.2);
        }

        .back-btn:hover {
            background-color: #0288d1;
            box-shadow: 0 6px 18px rgba(2, 136, 209, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="page-title">Patient Profile</h4>
                </div>
            </div>

            <div class="card-box p-4 shadow-sm">
                <div class="row">
                    <div class="text-center col-md-4">
                        <img src="{{ $patient->user->image ? asset($patient->user->image) : asset('assets/img/user.jpg') }}"
                            alt="Patient Image" class="profile-image mb-3">
                        <h4 class="mt-2">{{ $patient->user->name }}</h4>

                        <a href="{{ route('doctor.patient.records', $patient) }}"
                            class="btn btn-outline-primary"
                            style="border-radius: 25px; padding: 8px 25px; font-weight:600;">
                            <i class="fas fa-file-medical me-1"></i> View Medical Records
                        </a>
                    </div>

                    <div class="col-md-8">
                        {{-- General Information --}}
                        <h5 class="section-title text-primary">
                            <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                        </h5>
                        <table class="table table-borderless mb-4">
                            <tr>
                                <th><i class="fas fa-envelope text-primary me-2"></i> Email:</th>
                                <td>{{ $patient->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone text-primary me-2"></i> Phone:</th>
                                <td>{{ $patient->user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-alt text-primary me-2"></i> Date of Birth:</th>
                                <td>{{ $patient->user->date_of_birth ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-venus-mars text-primary me-2"></i> Gender:</th>
                                <td>{{ $patient->user->gender ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt text-primary me-2"></i> Address:</th>
                                <td>{{ $patient->user->address ?? '-' }}</td>
                            </tr>
                        </table>

                        {{-- Medical Information --}}
                        <h5 class="section-title text-primary">
                            <i class="fas fa-stethoscope me-2 text-primary"></i> Medical Information
                        </h5>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th><i class="fas fa-tint text-primary me-2"></i> Blood Type:</th>
                                <td>{{ $patient->blood_type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone-alt text-primary me-2"></i> Emergency Contact:</th>
                                <td>{{ $patient->emergency_contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-allergies text-primary me-2"></i> Allergies:</th>
                                <td>{{ $patient->allergies ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-heartbeat text-primary me-2"></i> Chronic Diseases:</th>
                                <td>{{ $patient->chronic_diseases ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('doctor.patients') }}" class="btn back-btn">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

@endsection
