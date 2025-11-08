@extends('Backend.doctors.master')

@section('title', 'My Profile')

@section('content')
    <style>
        body {
            background: #f6f9fc;
        }

        .profile-card {
            border-radius: 20px;
            background: linear-gradient(145deg, #ffffff, #f0f9ff);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            padding: 35px;
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(3, 169, 244, 0.2);
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #03A9F4;
            box-shadow: 0 6px 18px rgba(3, 169, 244, 0.3);
            transition: transform 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .page-title {
            font-weight: 600;
            color: #03A9F4;
            text-align: center;
            margin-bottom: 25px;
        }

        .profile-item {
            background: #fff;
            border-radius: 12px;
            padding: 10px 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .profile-item:hover {
            background-color: #f3f9ff;
            transform: translateY(-2px);
        }

        .profile-item i {
            color: #03A9F4;
            width: 22px;
            text-align: center;
        }

        .profile-section-title {
            font-weight: 700;
            color: #03A9F4;
            margin-bottom: 15px;
            border-left: 4px solid #03A9F4;
            padding-left: 10px;
        }

        .clinic-link {
            display: inline-block;
            padding: 5px 14px;
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
            font-weight: 600;
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

        hr {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 25px 0;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="p-4 rounded-4"
                        style="background: linear-gradient(135deg, #03A9F4, #81D4FA);
                    color: white;
                    box-shadow: 0 6px 20px rgba(3, 169, 244, 0.25);
                    border-radius: 15px;">
                        <h2 class="mb-2" style="font-weight: 700;">
                            <i class="fa fa-user-circle me-2"></i> My Profile
                        </h2>
                        <p class="mb-0" style="font-size: 15px; opacity: 0.9;">
                            View your personal and professional information in one place.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card">

                        {{-- Profile Image & Name --}}
                        <div class="mb-5 text-center position-relative">
                            <div class="p-5 rounded-4"
                                style="background: linear-gradient(145deg, #f5faff 0%, #e3f2fd 100%);
                                    border: 1px solid #d0e7fb;
                                    box-shadow: 0 8px 20px rgba(3, 169, 244, 0.15);
                                    position: relative;
                                    overflow: hidden;">
                                <div class="position-relative d-inline-block">
                                    <div style="position: relative; display: inline-block;">
                                        <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/default-user.png') }}"
                                            alt="Doctor Image" class="img-fluid rounded-circle"
                                            style="width: 140px; height: 140px; object-fit: cover;
                                                border: 5px solid #fff;
                                                box-shadow: 0 6px 15px rgba(0,0,0,0.2);
                                                background: #fff;">
                                        <span class="position-absolute bottom-0 end-0 translate-middle badge rounded-circle"
                                            style="background:#03A9F4; padding:10px; border:3px solid #fff;">
                                            <i class="fa fa-stethoscope text-white"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h2 class="mb-0" style="font-weight:700; color:#222;">
                                        {{ $doctor->employee->user->name }}</h2>
                                    <p class="text-muted" style="font-size:15px; margin-bottom: 0;">
                                        {{ ucfirst($doctor->speciality ?? 'Doctor') }}</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- General Information --}}
                        <h5 class="profile-section-title">
                            <i class="fas fa-info-circle me-2"></i> General Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fa fa-envelope me-2"></i>
                                    <strong>Email:</strong>
                                    <span class="text-muted"> {{ $doctor->employee->user->email }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fa fa-calendar me-2"></i>
                                    <strong>Birth Date:</strong>
                                    <span class="text-muted"> {{ $doctor->employee->user->date_of_birth ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fa fa-phone me-2"></i>
                                    <strong>Phone:</strong>
                                    <span class="text-muted"> {{ $doctor->employee->user->phone ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-venus-mars me-2"></i>
                                    <strong>Gender:</strong>
                                    <span class="text-muted"> {{ ucfirst($doctor->employee->user->gender ?? 'N/A') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <strong>Address:</strong>
                                    <span class="text-muted"> {{ $doctor->employee->user->address ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-id-badge me-2"></i>
                                    <strong>Specialization:</strong>
                                    <span class="text-muted"> {{ $doctor->speciality ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    <strong>Qualification:</strong>
                                    <span class="text-muted"> {{ $doctor->qualification ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    <strong>Consultation Fee:</strong>
                                    <span class="text-muted"> ${{ number_format($doctor->consultation_fee, 2) }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-star me-2"></i>
                                    <strong>Rating:</strong>
                                    <span class="rating"> {{ $doctor->rating ?? 0 }}/5</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="profile-item">
                                    <i class="fas fa-hospital me-2"></i>
                                    <strong>Clinic:</strong>
                                    @if ($doctor->employee->clinic)
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
                    </div>

                    {{-- Actions: Back + Edit --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ url()->previous() }}" class="btn back-btn">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>

                        <a href="{{ route('doctor.profile.edit') }}" class="btn back-btn"
                        style="background-color: #ffc107; border-color: #ffc107;">
                            <i class="fa fa-edit me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
