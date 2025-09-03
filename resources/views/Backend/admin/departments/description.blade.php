@extends('Backend.master')

@section('title', 'Department Details')

@section('content')

<style>
    li a {
        color: #5e6973;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    li a:hover {
        color: #049cf5;
    }
</style>
<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Department Details</h4>
            </div>
        </div>

        <div class="card-box">
            <h4 class="mb-4 card-title"><i class="fa fa-info-circle text-primary me-2"></i> General Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Department Name:</strong> {{ $department->name }}</p>
                    <p><strong>Clinics offering this Department:</strong> {{ $count_clinics }}</p>
                    <p><strong>Doctors in this Department:</strong> {{ $count_doctor }}</p>
                </div>
            </div>
        </div>

        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-stethoscope text-primary me-2"></i> Associated Clinics</h4>
            @if($department->clinics->isNotEmpty())
                <ul class="mb-0">
                    @foreach($department->clinics as $clinic)
                        <li><a href="{{ route('description_clinic', $clinic->id) }}">{{ $clinic->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p>No Clinics Are Available For This Department</p>
            @endif
        </div>

        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-user-md text-primary me-2"></i> Doctors in this Department</h4>
            @if($department->doctors->isNotEmpty())
                <ul class="mb-0">
                    @foreach($department->doctors as $doctor)
                        <li><a href="{{ route('profile_doctor', $doctor->id) }}">{{ $doctor->employee->user->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p>There Are No Doctors Available At The Moment</p>
            @endif
        </div>


            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-align-left text-primary me-2"></i> Description</h4>
                <div class="row">
                    <div class="col-md-12">
                        @if(!empty($department->description))
                            <p style="line-height: 1.8; font-size: 16px;">{{ $department->description }}</p>
                        @else
                        <p style="line-height: 1.8; font-size: 16px;">Description Not Available Yet</p>
                        @endif
                    </div>
                </div>
            </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('view_departments') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>
@endsection
