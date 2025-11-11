@extends('Backend.clinics_managers.master')

@section('title' , 'Clinic Profile')

@section('content')

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
        <div class="border-0 shadow-sm card rounded-4">
            <div class="card-body">

                <div class="mb-4 text-center">
                    <img src="{{ asset('assets/img/logo-dark.png') }}"
                         alt="Clinic Logo"
                         class="border shadow-sm rounded-circle border-3 border-light"
                         width="120" height="120">
                    <h2 class="mt-3 mb-1 fw-bold">{{ $clinic->name }}</h2>
                    <p class="mb-0 text-muted"><i class="fa fa-map-marker-alt"></i> {{ $clinic->location }}</p>
                </div>

                <hr>

                <div class="row text-start">
                    <div class="mb-3 col-md-6">
                        <div class="p-3 rounded shadow-sm d-flex align-items-center" style="background-color: #ebeaea;">
                            <span class="p-3 badge bg-danger rounded-circle me-4">
                                <i class="text-white fa fa-envelope fa-lg"></i>
                            </span>
                            <div>
                                <span class="fw-bold text-dark">&nbsp;&nbsp; Email</span><br>
                                <span class="text-dark">&nbsp;&nbsp; {{ $clinic->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <div class="p-3 rounded shadow-sm d-flex align-items-center" style="background-color: #ebeaea;">
                            <span class="p-3 badge bg-success rounded-circle me-4">
                                <i class="text-white fa fa-phone fa-lg"></i>
                            </span>
                            <div>
                                <span class="fw-bold text-dark">&nbsp;&nbsp; Phone</span><br>
                                <span class="text-dark">&nbsp;&nbsp; {{ $clinic->phone }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <div class="p-3 rounded shadow-sm d-flex align-items-center" style="background-color: #ebeaea;">
                            <span class="p-3 badge bg-warning rounded-circle me-4">
                                <i class="text-white fa fa-clock fa-lg"></i>
                            </span>
                            <div>
                                <span class="fw-bold text-dark">&nbsp;&nbsp; Working Hours</span><br>
                                <span class="text-dark">&nbsp;&nbsp;
                                    {{ \Carbon\Carbon::parse($clinic->opening_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($clinic->closing_time)->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <div class="p-3 rounded shadow-sm d-flex align-items-center" style="background-color: #ebeaea;">
                            <span class="p-3 badge bg-primary rounded-circle me-4">
                                <i class="text-white fa fa-calendar fa-lg"></i>
                            </span>
                            <div>
                                <span class="fw-bold text-dark">&nbsp;&nbsp; Working Days</span><br>
                                <span class="text-dark">&nbsp;&nbsp; {{ implode(', ', $clinic->working_days) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="card-body" style="background-color: #ebeaea;">
                        <h4 class="mb-3 fw-bold d-flex align-items-center" style="font-size: 20px;">
                            <i class="fas fa-align-left me-3 text-primary" style="font-size: 22px;"></i>
                            &nbsp;&nbsp; About the Clinic
                        </h4>
                        <p class="mb-0" style="font-size: 15px; color: #333;">
                            {{ $clinic->description ? $clinic->description : 'No Description Available Yet' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ Route('clinic_manager_dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>
    </div>
</div>
@endsection

