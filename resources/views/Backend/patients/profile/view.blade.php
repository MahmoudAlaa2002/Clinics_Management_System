@extends('Backend.patients.master')

@section('title', 'Patient Profile')

@section('content')

<section class="patient-profile-section py-4 py-lg-5">

    <style>
        .patient-profile-section{
            background:#f3f6fb;
        }

        .pp-wrapper{
            max-width:1200px;
            margin:0 auto;
        }

        .pp-header{
            margin-bottom:20px;
        }

        .pp-title{
            font-size:24px;
            font-weight:700;
            color:#1f2b3e;
            margin-bottom:4px;
        }

        .pp-subtitle{
            font-size:13px;
            color:#8a94aa;
        }

        .pp-header-btn{
            border-radius:10px;
            border:1px solid #00A8FF;
            color:#00A8FF;
            font-weight:600;
            padding:8px 18px;
            transition:.2s;
            font-size:13px;
        }

        .pp-header-btn:hover{
            background:#00A8FF;
            color:#fff;
        }

        .pp-card{
            background:#fff;
            border-radius:18px;
            border:1px solid #e3e8f3;
            box-shadow:0 14px 30px rgba(15, 23, 42, .06);
            overflow:hidden;
        }

        /* LEFT SIDEBAR */
        .pp-sidebar{
            background:linear-gradient(180deg, #00A8FF 0%, #0692de 40%, #0f172a 100%);
            color:#fff;
            padding:26px 22px;
            height:100%;
        }

        .pp-avatar{
            width:110px;
            height:110px;
            border-radius:50%;
            object-fit:cover;
            border:4px solid rgba(255,255,255,.7);
            box-shadow:0 10px 24px rgba(0,0,0,.25);
        }

        .pp-name{
            font-size:19px;
            font-weight:700;
            margin-top:12px;
            margin-bottom:4px;
        }

        .pp-role{
            font-size:12px;
            opacity:.9;
        }

        .pp-status-pill{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 10px;
            border-radius:999px;
            background:rgba(46, 213, 115, .15);
            color:#b8f7ce;
            font-size:11px;
            margin-top:10px;
            margin-bottom:18px;
        }

        .pp-status-pill i{
            font-size:10px;
        }

        .pp-sidebar-item{
            font-size:13px;
            margin-bottom:10px;
            padding-bottom:10px;
            border-bottom:1px dashed rgba(255,255,255,.15);
        }

        .pp-sidebar-label{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.06em;
            opacity:.7;
        }

        .pp-sidebar-value{
            font-size:13px;
        }

        /* RIGHT CONTENT */
        .pp-content{
            padding:22px 24px 22px 24px;
        }

        .pp-section-title{
            font-size:14px;
            font-weight:700;
            color:#1f2b3e;
            margin-bottom:12px;
            display:flex;
            align-items:center;
            gap:8px;
        }

        .pp-section-title i{
            color:#00A8FF;
            font-size:16px;
        }

        .pp-divider{
            height:1px;
            background:#e3e8f3;
            margin:18px 0;
        }

        .pp-field-label{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#9aa3b8;
            margin-bottom:2px;
        }

        .pp-field-value{
            font-size:13px;
            color:#374151;
        }

        .pp-highlight-badge{
            display:inline-block;
            padding:4px 10px;
            border-radius:999px;
            background:#eef7ff;
            color:#00A8FF;
            font-size:11px;
            margin-top:4px;
        }

        .pp-list-block{
            background:#f8fafc;
            border-radius:14px;
            padding:10px 12px;
            font-size:13px;
            color:#4b5563;
            min-height:40px;
        }

        .pp-status-pill i{
            color:#17dd60;   /* لون الدائرة */
            font-size:10px;
        }



        @media (max-width: 991.98px){
            .pp-card{
                border-radius:16px;
            }
            .pp-sidebar{
                border-radius:16px 16px 0 0;
            }
            .pp-content{
                padding:18px 16px 20px 16px;
            }
        }

    </style>

    <div class="pp-wrapper">

        {{-- Header --}}
        <div class="pp-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <div class="pp-title">Patient Profile</div>
            </div>

            <div>
                <a href="{{ route('patient.edit_profile') }}" class="pp-header-btn">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Profile
                </a>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="pp-card">

            <div class="row g-0">

                {{-- LEFT SIDEBAR --}}
                <div class="col-lg-4">
                    <div class="pp-sidebar h-100">

                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/'.auth()->user()->image ?? 'assets/img/user.jpg') }}"
                                 class="pp-avatar" alt="Patient Avatar">

                            <div class="pp-name">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="pp-role">
                                Patient Account
                            </div>

                            <div class="pp-status-pill">
                                <i class="fa-solid fa-circle"></i> Active
                            </div>
                        </div>

                        <div class="pp-sidebar-item">
                            <div class="pp-sidebar-label">Email</div>
                            <div class="pp-sidebar-value">
                                {{ auth()->user()->email }}
                            </div>
                        </div>

                        <div class="pp-sidebar-item">
                            <div class="pp-sidebar-label">Phone</div>
                            <div class="pp-sidebar-value">
                                {{ auth()->user()->phone ?? 'Not provided' }}
                            </div>
                        </div>

                        <div class="pp-sidebar-item">
                            <div class="pp-sidebar-label">Address</div>
                            <div class="pp-sidebar-value">
                                {{ auth()->user()->address ?? 'Not provided' }}
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT CONTENT --}}
                <div class="col-lg-8">
                    <div class="pp-content">

                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="pp-field-label">Patient ID</div>
                                <div class="pp-field-value">
                                    #{{ $patient->id ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="pp-field-label">Profile Created</div>
                                <div class="pp-field-value">
                                    {{ auth()->user()->created_at ? auth()->user()->created_at->format('Y-m-d') : 'Not available' }}
                                </div>
                            </div>
                        </div>

                        <div class="pp-divider"></div>

                        {{-- BASIC INFO --}}
                        <div class="mb-2">
                            <div class="pp-section-title">
                                <i class="fa-solid fa-circle-user"></i>
                                Basic Information
                            </div>

                            <div class="row gy-3">

                                <div class="col-md-4">
                                    <div class="pp-field-label">Gender</div>
                                    <div class="pp-field-value">
                                        {{ auth()->user()->gender ?? 'Not specified' }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="pp-field-label">Date of Birth</div>
                                    <div class="pp-field-value">
                                        {{ auth()->user()->date_of_birth ?? 'Not specified' }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="pp-field-label">Age</div>
                                    <div class="pp-field-value">
                                        @if(auth()->user()->date_of_birth)
                                            {{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->age }} years
                                        @else
                                            Not specified
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="pp-divider"></div>

                        {{-- MEDICAL INFO --}}
                        <div class="mb-2">

                            <div class="pp-section-title">
                                <i class="fa-solid fa-heart-pulse"></i>
                                Medical Information
                            </div>

                            <div class="row gy-3">

                                {{-- العمود الأول --}}
                                <div class="col-md-6">

                                    <div class="pp-field-label">Emergency Contact</div>
                                    <div class="pp-field-value mb-3">
                                        {{ $patient->emergency_contact ?? 'Not specified' }}
                                    </div>

                                    <div class="pp-field-label">Blood Type</div>
                                    <div class="pp-field-value mb-3">
                                        {{ $patient->blood_type ?? 'Not specified' }}
                                    </div>

                                    <div class="pp-field-label">Chronic Diseases</div>
                                    <div class="pp-field-value">
                                        {{ $patient->chronic_diseases ?? 'None reported' }}
                                    </div>

                                </div>

                                {{-- العمود الثاني --}}
                                <div class="col-md-6">

                                    <div class="pp-field-label">Allergies</div>
                                    <div class="pp-field-value mb-3">
                                        {{ $patient->allergies ?? 'None reported' }}
                                    </div>

                                    <div class="pp-field-label">Status</div>
                                    <div class="pp-field-value">
                                        Active Patient
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection
