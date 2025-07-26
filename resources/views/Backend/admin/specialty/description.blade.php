@extends('Backend.master')

@section('title', 'Specialty Details')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Specialty Details</h4>
            </div>
        </div>

        <div class="card-box">
            <h4 class="mb-4 card-title"><i class="fa fa-info-circle text-primary me-2"></i> General Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Specialty Name:</strong> {{ $specialty->name }}</p>
                    <p><strong>Clinics Offering this Specialty:</strong> {{ $count_clinics }}</p>
                    <p><strong>Doctors in this Specialty:</strong> {{ $count_doctor }}</p>
                </div>
            </div>
        </div>

        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-stethoscope text-primary me-2"></i> Associated Clinics</h4>
            @if($specialty->clinics->isNotEmpty())
                <ul class="mb-0">
                    @foreach($specialty->clinics as $clinic)
                        <li>{{ $clinic->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>No clinics are available for this specialty.</p>
            @endif
        </div>

        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-user-md text-primary me-2"></i> Doctors in this Specialty</h4>
            @if($specialty->doctors->isNotEmpty())
                <ul class="mb-0">
                    @foreach($specialty->doctors as $doctor)
                        <li>{{ $doctor->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>There are no doctors available at the moment.</p>
            @endif
        </div>


            <div class="card-box">
                <h4 class="card-title"><i class="fa fa-align-left text-primary me-2"></i> Description</h4>
                <div class="row">
                    <div class="col-md-12">
                        @if(!empty($specialty->description))
                            <p style="line-height: 1.8; font-size: 16px;">{{ $specialty->description }}</p>
                        @else
                        <p style="line-height: 1.8; font-size: 16px;">Description not available yet.</p>
                        @endif
                    </div>
                </div>
            </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('view_specialties') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>
@endsection
