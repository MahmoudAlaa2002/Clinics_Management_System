@extends('Backend.doctors.master')

@section('title', 'My Profile')

@section('content')
<style>
    .profile-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #03A9F4;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .profile-item i {
        color: #03A9F4;
        width: 25px;
    }

    .back-btn {
        background-color: #03A9F4;
        color: white;
        border-radius: 50px;
        padding: 8px 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0288d1;
    }

    .clinic-link {
        display: inline-block;
        padding: 4px 12px;
        background-color: #e3f2fd;
        color: #03A9F4;
        font-weight: 600;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .clinic-link:hover {
        background-color: #03A9F4;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .rating {
        color: #ffc107;
        font-weight: bold;
    }

    .profile-section-title {
        font-weight: bold;
        color: #03A9F4;
        margin-bottom: 10px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">My Profile</h4>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-4 profile-card">

                    {{-- Profile Image & Name --}}
                    <div class="mb-4 text-center">
                        <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/default-user.png') }}"
                             alt="Doctor Image"
                             class="profile-image img-fluid rounded-circle"
                             style="width: 150px; height:150px;">
                        <h2 class="mt-3 mb-0">{{ $doctor->employee->user->name }}</h2>
                        <p class="text-muted">Doctor</p>
                    </div>

                    <hr>

                    {{-- General Information --}}
                    <h5 class="profile-section-title">
                        <i class="fas fa-info-circle me-2"></i> General Information
                    </h5>

                    <div class="mb-4 row" style="margin-left:5px;">
                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-envelope me-2"></i>
                            <strong>Email :</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->employee->user->email }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-calendar me-2"></i>
                            <strong>Birth Date:</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->employee->user->date_of_birth ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-phone me-2"></i>
                            <strong>Phone :</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->employee->user->phone ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-venus-mars me-2"></i>
                            <strong>Gender:</strong>&nbsp;
                            <span class="text-muted">{{ ucfirst($doctor->employee->user->gender ?? 'N/A') }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <strong>Address :</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->employee->user->address ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-id-badge me-2"></i>
                            <strong>Specialization:</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->speciality ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-graduation-cap me-2"></i>
                            <strong>Qualification:</strong>&nbsp;
                            <span class="text-muted">{{ $doctor->qualification ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            <strong>Consultation Fee:</strong>&nbsp;
                            <span class="text-muted">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-star me-2"></i>
                            <strong>Rating:</strong>&nbsp;
                            <span class="rating">{{ $doctor->rating ?? 0 }}/5</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-hospital me-2"></i>
                            <strong>Clinic:</strong>&nbsp;
                            @if($doctor->employee->clinic)
                                <a href="{{ route('doctor.clinic.show', $doctor->employee->clinic->id) }}"
                                   class="clinic-link">
                                    {{ $doctor->employee->clinic->name }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Back Button --}}
                <div class="mb-3 d-flex justify-content-end" style="margin-top:15px;">
                    <a href="{{ route('doctor_dashboard') }}" class="btn back-btn">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
