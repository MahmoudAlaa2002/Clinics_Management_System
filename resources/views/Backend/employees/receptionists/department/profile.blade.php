@extends('Backend.employees.receptionists.master')

@section('title' , 'Receptionist Dashboard')

@section('content')

<style>
    .profile-header {
        background: linear-gradient(135deg, #00A8FF, #00A8FF);
        padding: 40px 0;
        border-radius: 18px;
        color: white;
        text-align: center;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    .info-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        transition: 0.2s;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    .desc-box {
        background: #f7f9fc;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05);
    }

    .circle-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #eef6ff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
        color: #00A8FF;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="mb-4 profile-header">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3 circle-icon">
                    <i class="fa fa-building"></i>
                </div>
                <h2 class="mb-1 fw-bold">{{ $clinicDepartment->department->name }}</h2>
                <p class="mb-0" style="font-size: 15px;">
                    Clinic: <strong>{{ $clinic->name }}</strong>
                </p>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="info-card d-flex align-items-center">
                    <span class="p-3 text-white shadow-sm rounded-circle bg-warning me-3">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <div>
                        <h6 class="m-0 fw-bold text-dark" style="font-size: 17px; font-weight: 700;">
                            &nbsp;&nbsp;Added to Clinic
                        </h6>
                        <p class="m-0 text-dark" style="font-size: 15px;">
                            &nbsp;&nbsp;{{ $departmentCreatedAt }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card d-flex align-items-center">

                    @if($clinicDepartment->status === 'active')
                        <span class="p-3 text-white shadow-sm rounded-circle bg-success me-3">
                            <i class="fa fa-check fa-lg"></i>
                        </span>
                    @else
                        <span class="p-3 text-white shadow-sm rounded-circle bg-danger me-3">
                            <i class="fa fa-times fa-lg"></i>
                        </span>
                    @endif

                    <div>
                        <h6 class="m-0 fw-bold text-dark" style="font-size: 17px; font-weight: 700;">
                            &nbsp;&nbsp;Status
                        </h6>
                        <p class="m-0 text-dark" style="font-size: 15px;">
                            &nbsp;&nbsp;{{ ucfirst($clinicDepartment->status) }}
                        </p>
                    </div>
                </div>
            </div>



        </div>

        <div class="mt-4">
            <div class="p-4 shadow-sm desc-box rounded-4"
                 style="background: #ffffff; border: 1px solid #e5e7eb;">

                <div class="mb-3 d-flex align-items-center">
                    <span class="d-flex justify-content-center align-items-center me-2"
                          style="width: 38px; height: 38px; background:#e8f3ff; color:#00A8FF; border-radius: 8px;">
                        <i class="fa fa-info-circle" style="font-size:18px;"></i>
                    </span>
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 20px;">
                        Department Description
                    </h5>
                </div>

                <p class="mt-2 text-secondary"
                   style="font-size: 16px; line-height: 1.9; padding-left: 5px;">
                    {{ $clinicDepartment->description ? $clinicDepartment->description : 'No Description Available Yet' }}
                </p>
            </div>
        </div>

    </div>
    <div class="mb-3 d-flex justify-content-end" style="margin-right: 30px;">
        <a href="{{ Route('receptionist_dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
            Back
        </a>
    </div>
</div>

@endsection
