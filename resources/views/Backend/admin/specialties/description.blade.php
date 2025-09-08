@extends('Backend.admin.master')

@section('title', 'Specialty Details')

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
                <h4 class="page-title">Specialty Details</h4>
            </div>
        </div>

        {{-- معلومات عامة --}}
        <div class="card-box">
            <h4 class="mb-4 card-title"><i class="fa fa-info-circle text-primary me-2"></i> General Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Specialty Name:</strong> {{ $specialty->name }}</p>
                    <p><strong>Clinics offering this Specialty:</strong> {{ $count_clinics }}</p>
                    <p><strong>Associated Departments:</strong> {{ $count_departments }}</p>
                    <p><strong>Doctors in this Specialty:</strong> {{ $count_doctor }}</p>
                </div>
            </div>
        </div>

        {{-- العيادات المرتبطة --}}
        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-hospital text-primary me-2"></i> Clinics Offering This Specialty</h4>
            @if($count_clinics > 0)
                <ul class="mb-0">
                    @php
                        // نجمع كل العيادات من الأقسام ونخليها unique
                        $clinics = $specialty->departments->flatMap->clinics->unique('id');
                    @endphp

                    @foreach($clinics as $clinic)
                        <li>
                            <a href="{{ route('description_clinic', $clinic->id) }}">
                                {{ $clinic->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Clinics Are Available For This Specialty</p>
            @endif
        </div>


        {{-- الأقسام المرتبطة --}}
        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-building text-primary me-2"></i> Associated Departments</h4>
            @if($specialty->departments->isNotEmpty())
                <ul class="mb-0">
                    @foreach($specialty->departments as $department)
                        <li>
                            <a href="{{ route('description_department', $department->id) }}">
                                {{ $department->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No Departments Are Available For This Specialty</p>
            @endif
        </div>

        {{-- الأطباء المرتبطين --}}
        <div class="card-box">
            <h4 class="mb-3 card-title"><i class="fa fa-user-md text-primary me-2"></i> Doctors in this Specialty</h4>
            @if($count_doctor > 0)
                <ul class="mb-0">
                    @php
                        // نجمع كل الدكاترة من الأقسام والعيادات ونخليهم unique حسب id
                        $doctors = $specialty->departments
                            ->flatMap->clinics
                            ->flatMap->doctors
                            ->where('specialty_id', $specialty->id)
                            ->unique('id');
                    @endphp

                    @foreach($doctors as $doctor)
                        <li>
                            <a href="{{ route('profile_doctor', $doctor->id) }}">
                                {{ $doctor->employee->user->name }}
                            </a>
                        </li>
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
                    @if(!empty($specialty->description))
                        <p style="line-height: 1.8; font-size: 16px;">{{ $specialty->description }}</p>
                    @else
                    <p style="line-height: 1.8; font-size: 16px;">Description Not Available Yet</p>
                    @endif
                </div>
            </div>
        </div>


        {{-- رجوع --}}
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('view_specialties') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>

    </div>
</div>
@endsection
