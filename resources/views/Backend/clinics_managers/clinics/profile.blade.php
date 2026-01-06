@extends('Backend.clinics_managers.master')

@section('title' , 'Clinic Profile')

@section('content')

<style>
    .profile-header {
        background: linear-gradient(135deg, #00A8FF, #00A8FF);
        padding: 80px 20px 110px;
        border-radius: 20px;
        position: relative;
        text-align: center;
        color: white;
    }

    .profile-logo {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 5px solid white;
        position: absolute;
        left: 50%;
        bottom: -70px;
        transform: translateX(-50%);
        background: #fff;
        object-fit: cover;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .profile-container {
        margin-top: 90px;
    }

    .info-card {
        padding: 20px;
        border-radius: 16px;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all .3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    .info-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 22px;
        color: white;
        margin-right: 18px;
    }

    .about-section {
        background: white;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .btn-back {
        font-weight: bold;
        border-radius: 50px;
        padding: 10px 20px;
    }
</style>


<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Clinic Profile</h3>
                </div>
                <div class="text-right col-sm-8 col-9 m-b-20">
                    <a href="{{ route('edit_clinic_profile', $clinic->id) }}" class="float-right btn btn-primary btn-rounded"> <i class="fa fa-edit"></i> Edit Clinic Profile</a>
                </div>
            </div>
        </div>

        <!-- ===================== HEADER ===================== -->
        <div class="profile-header">
            <h1 class="fw-bold">{{ $clinic->name }}</h1>
            <p class="mb-0"><i class="fa fa-map-marker-alt"></i> {{ $clinic->location }}</p>

            <img src="{{ asset('assets/img/logo-dark.png') }}" class="profile-logo">
        </div>

        <!-- ===================== CONTENT ===================== -->
        <div class="profile-container container">

            <div class="row g-4">

                <!-- Email -->
                <div class="col-md-6">
                    <div class="d-flex info-card">
                        <div class="info-icon" style="background:#ff4b5c;">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Email</h5>
                            <p class="mb-0 text-muted">{{ $clinic->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <div class="d-flex info-card">
                        <div class="info-icon" style="background:#28c76f;">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Phone</h5>
                            <p class="mb-0 text-muted">{{ $clinic->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="col-md-6" style="margin-top: 20px;">
                    <div class="d-flex info-card">
                        <div class="info-icon" style="background:#ff9f43;">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Working Hours</h5>
                            <p class="mb-0 text-muted">
                                {{ \Carbon\Carbon::parse($clinic->opening_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($clinic->closing_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Working Days -->
                <div class="col-md-6" style="margin-top: 20px;">
                    <div class="d-flex info-card">
                        <div class="info-icon" style="background:#7367f0;">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Working Days</h5>
                            <p class="mb-0 text-muted">{{ implode(', ', $clinic->working_days) }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- About -->
            <div class="mt-5 about-section">
                <h4 class="fw-bold mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    About the Clinic
                </h4>
                <p style="font-size: 16px;">
                    {{ $clinic->description ? $clinic->description : 'No Description Available Yet' }}
                </p>
            </div>

            <div class="my-4 d-flex justify-content-end">
                <a href="{{ Route('clinic_manager_dashboard') }}" class="btn btn-primary btn-back">Back</a>
            </div>

        </div>

    </div>
</div>

@endsection
