@extends('Backend.patients.master')

@section('title', 'Profile View')

@section('content')
<section class="mt-5 mb-5">

    <style>
        .profile-wrapper{
            background:#f8fbff;
            padding:25px;
            border-radius:18px;
        }

        .profile-title{
            color:#007BFF;
            font-weight:700;
            text-align:center;
            margin-bottom:25px;
        }

        .profile-card{
            border-radius:18px;
            border:1px solid #e6ecf3;
            box-shadow:0 12px 25px rgba(0,0,0,.05);
        }

        .profile-card .card-body{
            padding:26px;
        }

        .avatar{
            width:140px;
            height:140px;
            object-fit:cover;
            border-radius:50%;
            border:4px solid #eef3ff;
        }

        .badge-status{
            background:#28a745;
            font-size:12px;
        }

        .info-box{
            border-radius:16px;
            border:1px solid #e6ecf3;
            padding:18px;
            margin-bottom:16px;
        }

        .info-title{
            font-weight:600;
            font-size:16px;
            color:#007BFF;
            margin-bottom:12px;
        }

    </style>

    <div class="container profile-wrapper">

        <h2 class="profile-title">Patient Profile</h2>

        <div class="row gy-4">

            {{-- LEFT: USER CARD --}}
            <div class="col-lg-4">

                <div class="card profile-card">

                    <div class="card-body text-center">

                        <img src="{{ asset(auth()->user()->image ?? 'assets/img/user.jpg') }}"
                             class="avatar mb-3">

                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>

                        <span class="badge badge-status mb-2">Active Patient</span>

                        <p class="text-muted mb-1">
                            <i class="fa-solid fa-envelope me-2"></i>
                            {{ auth()->user()->email }}
                        </p>

                        <p class="text-muted mb-1">
                            <i class="fa-solid fa-phone me-2"></i>
                            {{ auth()->user()->phone }}
                        </p>

                        <p class="text-muted">
                            <i class="fa-solid fa-location-dot me-2"></i>
                            {{ auth()->user()->address ?? 'Not provided' }}
                        </p>

                        <a href="{{ route('patient.edit_profile') }}"
                           class="btn btn-outline-primary mt-2 px-4">
                            Edit Profile
                        </a>

                    </div>
                </div>
            </div>

            {{-- RIGHT: DETAILS --}}
            <div class="col-lg-8">

                {{-- BASIC INFO --}}
                <div class="info-box">

                    <div class="info-title">
                        <i class="fa-solid fa-user me-2"></i>
                        Basic Information
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <strong>Gender</strong>
                            <p class="text-muted m-0">
                                {{ auth()->user()->gender ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <strong>Date of Birth</strong>
                            <p class="text-muted m-0">
                                {{ auth()->user()->date_of_birth ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <strong>Age</strong>
                            <p class="text-muted m-0">
                                @if(auth()->user()->date_of_birth)
                                    {{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->age }} years
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>

                    </div>
                </div>

                {{-- MEDICAL INFO --}}
                <div class="info-box">

                    <div class="info-title">
                        <i class="fa-solid fa-heart-pulse me-2"></i>
                        Medical Information
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <strong>Blood Type</strong>
                            <p class="text-muted m-0">
                                {{ $patient->blood_type ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <strong>Emergency Contact</strong>
                            <p class="text-muted m-0">
                                {{ $patient->emergency_contact ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="col-md-12 mt-2">
                            <strong>Chronic Diseases</strong>
                            <p class="text-muted m-0">
                                {{ $patient->chronic_diseases ?? 'None' }}
                            </p>
                        </div>

                        <div class="col-md-12 mt-2">
                            <strong>Allergies</strong>
                            <p class="text-muted m-0">
                                {{ $patient->allergies ?? 'None' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    </section>

@endsection
