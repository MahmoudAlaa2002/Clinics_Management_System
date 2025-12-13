@extends('Backend.employees.receptionists.master')

@section('title', 'Doctor Profile')

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
            margin-bottom: 10px;
        }

        .profile-item i {
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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="p-4 profile-card">
                        <div class="mb-4 text-center">
                            <img src="{{ $doctor->employee->user->image ? asset($doctor->employee->user->image) : asset('assets/img/user.jpg') }}" alt=""
                                class="profile-image img-fluid rounded-circle" style="width: 150px; height:150px;">
                            <h2 class="mt-3 mb-0">{{ $doctor->employee->user->name }}</h2>
                            <p class="text-muted">Doctor</p>
                            <p class="text-primary fw-bold" style="font-size: 15px;">
                                [ {{ $doctor->employee->clinic->name }} - {{ $doctor->employee->department->name }} ]
                            </p>
                        </div>

                        <hr>
                        <h5 class="fw-bold" style="font-size: 18px; margin-bottom:20px;">
                            <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                        </h5>
                        <div class="mb-4 row" style="margin-left:5px;">

                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                <strong>Email:</strong>&nbsp;
                                <span class="text-muted">{{ $doctor->employee->user->email }}</span>
                            </div>

                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fas fa-stethoscope me-2 text-primary"></i>
                                <strong>Speciality:</strong>&nbsp;
                                <span class="text-muted">{{ $doctor->speciality ?? '-' }}</span>
                            </div>

                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fa fa-phone me-2 text-primary"></i>
                                <strong>Phone:</strong>&nbsp;
                                <span class="text-muted">{{ $doctor->employee->user->phone ?? 'N/A' }}</span>
                            </div>

                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                                <strong>Consultation Fee:</strong>&nbsp;
                                <span class="text-muted">
                                    $ {{ number_format($doctor->consultation_fee, 2) }}
                                </span>
                            </div>

                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fas fa-venus-mars me-2 text-primary"></i>
                                <strong>Gender:</strong>&nbsp;
                                <span class="text-muted">{{ ucfirst($doctor->employee->user->gender) }}</span>
                            </div>




                            <div class="mb-3 col-md-6 profile-item">
                                <i class="fa fa-clock me-2 text-primary"></i>
                                <strong>Work Time:</strong>&nbsp;
                                <span class="text-muted">
                                    {{ \Carbon\Carbon::parse($doctor->employee->work_start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($doctor->employee->work_end_time)->format('H:i') }}
                                </span>
                            </div>

                        </div>

                        <div class="mb-4" style="margin-bottom: 20px;">
                            <h5 class="mb-3 profile-section-title" style="font-size: 18px;">
                                <i class="fa fa-table me-2 text-primary"></i> Working Days
                            </h5>
                            @if($doctor->employee->working_days)
                                <ul>
                                    @foreach($doctor->employee->working_days as $day)
                                        <li>{{ $day }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="mb-4" style="margin-top:30px;">
                            <h5 class="mb-3 profile-section-title" style="font-size: 18px;">
                                <i class="fa fa-align-left text-primary me-2"></i> Biography
                            </h5>

                            <div style="background-color: #f9f9f9; border-left: 4px solid #03A9F4; padding: 15px; border-radius: 10px; min-height: 100px; margin-left:20px;">
                                <p class="mb-0 text-muted">{{ $doctor->employee->short_biography ?? 'No biography provided.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-end" style="margin-right: 240px;">
            <a href="{{ Route('receptionist.view_doctors') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>
    </div>
@endsection
