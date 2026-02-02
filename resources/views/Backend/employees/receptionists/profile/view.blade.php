@extends('Backend.employees.receptionists.master')

@section('title' , 'My Profile')

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

    .profile-section-title {
        font-weight: bold;
        color: #03A9F4;
        margin-bottom: 10px;
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
</style>

<div class="page-wrapper">
    <div class="content">
        <div>
            <div >
                <h4 class="page-title">My Profile</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-4 profile-card">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/'.$receptionist->image ?? 'assets/img/user.jpg') }}" alt=""
                            class="profile-image img-fluid rounded-circle" style="width: 150px; height:150px;">
                            <h2 class="mt-3 mb-0">{{ $receptionist->name }}</h2>
                        <p class="text-muted">Receptionist</p>

                        <p class="text-primary fw-semibold mb-0">
                            [ {{ $receptionist->employee->clinic->name ?? '-' }}
                                &nbsp;•&nbsp;
                            {{ $receptionist->employee->department->name ?? '-' }} ]
                        </p>
                    </div>

                    <hr>

                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                    </h5>
                    <div class="mb-4 row" style="margin-left:5px;">

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-envelope me-2 text-primary"></i>
                            <strong>Email:</strong>&nbsp;
                            <span class="text-muted">{{ $receptionist->email }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-calendar me-2 text-primary"></i>
                            <strong>Birth Date:</strong>&nbsp;
                            <span class="text-muted">{{ $receptionist->date_of_birth }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-phone me-2 text-primary"></i>
                            <strong>Phone:</strong>&nbsp;
                            <span class="text-muted">{{ $receptionist->phone ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                            <strong>Gender:</strong>&nbsp;
                            <span class="text-muted">{{ ucfirst($receptionist->gender) }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            <strong>Address:</strong>&nbsp;
                            <span class="text-muted">{{ $receptionist->address }}</span>
                        </div>

                    </div>

                    <hr>

                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Employment Information
                    </h5>
                    <div class="mb-4 row" style="margin-left:5px;">

                        <!-- Column 1 -->
                        <div class="col-md-6">

                            <div class="mb-3 profile-item d-flex align-items-center">
                                <i class="far fa-clock me-2 text-primary"></i>
                                <strong>Work Start Time:</strong>&nbsp;
                                <span class="text-muted">{{ $receptionist->employee->work_start_time }}</span>
                            </div>

                            <div class="mb-3 profile-item d-flex align-items-center">
                                <i class="far fa-clock me-2 text-primary"></i>
                                <strong>Work End Time:</strong>&nbsp;
                                <span class="text-muted">{{ $receptionist->employee->work_end_time }}</span>
                            </div>

                            <div class="mb-3 profile-item d-flex align-items-center">
                                <i class="fa fa-calendar-day me-2 text-primary"></i>
                                <strong>Hire Date:</strong>&nbsp;
                                <span class="text-muted">{{ $receptionist->employee->hire_date }}</span>
                            </div>

                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">

                            <div class="mb-3 profile-item d-flex align-items-center">
                                <i class="fas fa-calendar-check me-2 text-primary"></i>
                                <strong>Working Days:</strong>&nbsp;
                                <span class="text-muted">
                                    @php
                                        $days = $receptionist->employee->working_days ?? [];
                                    @endphp
                                    {{ implode(', ', $days) }}
                                </span>
                            </div>


                            <div class="mb-3 profile-item d-flex align-items-center">
                                <i class="fas fa-user-check me-2 text-primary"></i>
                                <strong>Status:</strong>&nbsp;
                                <span class="text-muted">{{ ucfirst($receptionist->employee->status) }}</span>
                            </div>

                        </div>

                    </div>


                    <hr>

                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Short Biography
                    </h5>

                    <div class="mb-4" style="background:#f9f9f9; padding:20px 25px; border-radius:12px; border-left:4px solid #03A9F4;">
                        <p class="text-muted" style="line-height:1.8; font-size:15px;">
                            {{ $receptionist->employee->short_biography ?? 'No biography available.' }}
                        </p>
                    </div>



                </div>


                <div class="mb-3 d-flex justify-content-end" style="margin-top:15px;">
                    <a href="{{ Route('receptionist_dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
