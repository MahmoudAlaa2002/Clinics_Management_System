@extends('Backend.master')
@section('title', 'Clinic Details')

@section('content')

    <style>
        li a {
            color: #5e6973;
            text-decoration: none;
            transition: color 0.3s ease;
            }

            li a:hover {
            color: #00a2ff;
            }
    </style>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Clinic Details</h4>
                </div>
            </div>

            <div class="card-box">
                <h4 class="card-title" style="margin-bottom: 20px;"><i class="fa fa-info-circle text-primary me-2"></i> General Information</h4>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Clinic Name:</strong> {{ $clinic->name }}</p>
                        <p><strong>Location:</strong> {{ $clinic->location }}</p>
                        <p><strong>Email:</strong> {{ $clinic->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Phone:</strong> {{ $clinic->phone }}</p>
                        <p><strong>Available Time:</strong> {{ $clinic->opening_time }} AM  -  {{ $clinic->closing_time }} PM</p>
                        <p><strong>Status:</strong>
                            @if($clinic->status == 'active')
                                <span class="badge badge-success" style="padding: 6px 15px; border-radius: 30px; background-color: #00c853;">Active</span>
                            @else
                                <span class="badge badge-danger" style="padding: 6px 15px; border-radius: 30px; background-color: #f90d25;">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Departments Count:</strong> {{ optional($clinic->departments)->count() ?? 0 }}</p>
                        <p><strong>Doctors Count:</strong> {{ optional($clinic->doctors)->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-calendar-alt text-primary me-2"></i> Available Days</h4>
                @if($clinic->working_days)
                    <ul>
                        @foreach(json_decode($clinic->working_days) as $day)
                            <li>{{ $day }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-stethoscope text-primary me-2"></i> Departments</h4>
                <ul>
                    @if($clinic->departments && $clinic->departments->count() > 0)
                        @foreach($clinic->departments as $department)
                            <li><a href="{{ route('description_department', $department->id) }}">{{ $department->name }}</a></li>
                        @endforeach
                    @else
                    <p>No Departments Available Yet</p>
                    @endif
                </ul>
            </div>

            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-user-md text-primary me-2"></i> Doctors</h4>
                @if($clinic->doctors && $clinic->doctors->count() > 0)
                    <ul>
                        @foreach($clinic->doctors as $doctor)
                            <li><a href="{{ route('profile_doctor', $doctor->id) }}">{{ $doctor->employee->user->name }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>No Doctors Available Yet</p>
                @endif
            </div>

            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-align-left text-primary me-2"></i> Description</h4>
                <div class="row">
                    <div class="col-md-12">
                        @if(!empty($clinic->description))
                            <p style="line-height: 1.8; font-size: 16px;">
                                {{ $clinic->description }}
                            </p>
                        @else
                            <p class="text-muted">Not available</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ Route('view_clinics') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection
