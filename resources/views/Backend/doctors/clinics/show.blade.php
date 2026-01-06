@extends('Backend.doctors.master')

@section('title', 'Clinic Details')

@section('content')
<style>
    li a {
        color: #5e6973;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    li a:hover {
        color: #00A8FF;
    }
    .badge-available {
        background-color: #28a745;
        color: #fff;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .badge-closed {
        background-color: #dc3545;
        color: #fff;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 20px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Clinic Details</h4>
            </div>
        </div>

        {{-- General Information --}}
        <div class="card-box">
            <h4 class="card-title mb-3"><i class="fa fa-info-circle text-primary me-2"></i> General Information</h4>
            <p><strong>Clinic Name:</strong> {{ $clinic->name }}</p>
            <p><strong>Location:</strong> {{ $clinic->location }}</p>
            <p><strong>Email:</strong> {{ $clinic->email }}</p>
            <p><strong>Phone:</strong> {{ $clinic->phone }}</p>
            <p><strong>Status:</strong>
                @if($clinic->status === 'active')
                    <span class="badge badge-available">Active</span>
                @else
                    <span class="badge badge-closed">Inactive</span>
                @endif
            </p>
        </div>

        {{-- Clinic Schedule --}}
        <div class="card-box">
            <h4 class="card-title mb-3"><i class="fa fa-calendar-alt text-primary me-2"></i> Clinic Schedule</h4>
            @if($clinic->working_days)
                <table class="table text-center table-bordered">
                    <thead style="background-color:#00A8FF; color:#fff;">
                        @if($clinic->opening_time && $clinic->closing_time)
                            <tr>
                                <th colspan="2">
                                    [ {{ \Carbon\Carbon::parse($clinic->opening_time)->format('h:i A') }}
                                    - {{ \Carbon\Carbon::parse($clinic->closing_time)->format('h:i A') }} ]
                                </th>
                            </tr>
                        @endif
                        <tr>
                            <th style="width: 150px;">Day</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                            <tr>
                                <td>{{ $day }}</td>
                                <td>
                                    @if(in_array($day, $clinic->working_days))
                                        <span class="badge-available">Available</span>
                                    @else
                                        <span class="badge-closed">Closed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No schedule available</p>
            @endif
        </div>

        {{-- Departments --}}
        <div class="card-box">
            <h4 class="card-title mb-3"><i class="fas fa-building text-primary me-2"></i> Departments</h4>
            @if($clinic->departments && $clinic->departments->count() > 0)
                <ul>
                    @foreach($clinic->departments as $department)
                        <li><a href="{{ route('details_department', $department->id) }}">{{ $department->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No Departments Available Yet</p>
            @endif
        </div>

        {{-- Doctors --}}
        <div class="card-box">
            <h4 class="card-title mb-3"><i class="fa fa-user-md text-primary me-2"></i> Doctors</h4>
            @if($doctors && $doctors->count() > 0)
                <ul>
                    @foreach($doctors as $doctor)
                        <li><a href="{{ route('profile_doctor', $doctor->id) }}">{{ $doctor->employee->user->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No Doctors Available Yet</p>
            @endif
        </div>

        {{-- Description --}}
        <div class="card-box">
            <h4 class="card-title mb-3"><i class="fa fa-align-left text-primary me-2"></i> Description</h4>
            <p>{{ $clinic->description ?? 'Not available' }}</p>
        </div>

        {{-- Back button --}}
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
