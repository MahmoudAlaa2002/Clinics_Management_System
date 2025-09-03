@extends('Backend.master')

@section('title', 'Patient Profile')

@section('content')

<style>
    .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #03A9F4;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-title">Patient Profile</h4>
            </div>
        </div>

        <div class="card-box">
            <div class="row">
                <div class="text-center col-md-4">
                    <img src="{{ $patient->user->image ? asset($patient->user->image) : asset('assets/img/user.jpg') }}" alt="Patient Image"
                            class="profile-image img-fluid rounded-circle" style="width: 150px; height:150px;">
                    <h4 class="mt-3">{{ $patient->user->name }}</h4>
                </div>

                <div class="col-md-8">
                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                    </h5>

                    <table class="table table-borderless" style="margin-bottom:50px;">
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
                            <td>{{ $patient->user->date_of_birth }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-venus-mars text-primary me-2"></i> Gender:</th>
                            <td>{{ $patient->user->gender }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-map-marker-alt text-primary me-2"></i> Address:</th>
                            <td>{{ $patient->user->address ?? '-' }}</td>
                        </tr>
                    </table>


                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Medical Information
                    </h5>

                    <table class="table table-borderless" style="margin-bottom:50px;">
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


                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom: 10px;">
                        <i class="fas fa-align-left me-2 text-primary"></i> Notes
                    </h5>

                    <div class="mb-4 shadow-sm card rounded-3">
                        <div class="card-body" style="background-color: #ebeaea;">
                            <p class="mb-0" style="font-size: 15px; color: #333;">
                                {{ $patient->user->notes ? $patient->user->notes : 'No notes available yet.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ Route('view_patients') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
