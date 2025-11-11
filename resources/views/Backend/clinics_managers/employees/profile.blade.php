@extends('Backend.clinics_managers.master')

@section('title', 'Employee Profile')

@section('content')

<style>
    .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #03A9F4;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-title">Employee Profile</h4>
            </div>
        </div>

        <div class="card-box">
            <div class="row">
                <div class="text-center col-md-4">
                    <img src="{{ $employee->user->image ? asset($employee->user->image) : asset('assets/img/user.jpg') }}" alt=""
                            class="profile-image img-fluid rounded-circle" style="width: 150px; height:150px;">
                    <h4 class="mt-3">{{ $employee->user->name }}</h4>
                </div>

                <div class="col-md-8">
                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                    </h5>

                    <table class="table table-borderless" style="margin-bottom:50px;">
                        <tr>
                            <th><i class="fas fa-envelope text-primary me-2"></i> Email:</th>
                            <td>{{ $employee->user->email ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-calendar-alt text-primary me-2"></i> Date of Birth:</th>
                            <td>{{ $employee->user->date_of_birth }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-phone text-primary me-2"></i> Phone:</th>
                            <td>{{ $employee->user->phone ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-venus-mars text-primary me-2"></i> Gender:</th>
                            <td>{{ $employee->user->gender }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-map-marker-alt text-primary me-2"></i> Address:</th>
                            <td>{{ $employee->user->address ?? '-' }}</td>
                        </tr>
                    </table>


                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                        <i class="fas fa-briefcase me-2 text-primary"></i> Employment Details
                    </h5>

                    <table class="table table-borderless" style="margin-bottom:50px;">
                        <tr>
                            <th><i class="fa fa-hospital text-primary me-2"></i> Clinic:</th>
                            <td>{{ $employee->clinic->name  }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-building text-primary me-2"></i> Department:</th>
                            <td>{{ $employee->department->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-briefcase text-primary me-2"></i> Job Title:</th>
                            <td>{{ $employee->job_title }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-calendar-alt text-primary me-2"></i> Hire Date:</th>
                            <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</td>
                        </tr>
                    </table>

                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i> Work Schedule
                    </h5>

                    <table class="table table-borderless" style="margin-bottom:50px;">
                        <tr>
                            <th><i class="fas fa-clock text-primary me-2"></i> Work Start Time:</th>
                            <td>{{ \Carbon\Carbon::parse($employee->work_start_time)->format('H:i') ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-clock text-primary me-2"></i> Work End Time:</th>
                            <td>{{ \Carbon\Carbon::parse($employee->work_end_time)->format('H:i') ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th><i class="fas fa-calendar-day text-primary me-2"></i> Working Days:</th>
                            <td>
                                @if(!empty($employee->working_days) && is_array($employee->working_days))
                                    <ul style="padding-left:20px; margin:0;">
                                        @foreach($employee->working_days as $day)
                                            <li>{{ ucfirst($day) }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($employee->job_title == 'Doctor')
                        <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:10px;">
                            <i class="fas fa-user-md me-2 text-primary"></i> Doctor Information
                        </h5>

                        <table class="table table-borderless" style="margin-bottom:50px;">
                            <tr>
                                <th><i class="fas fa-stethoscope text-primary me-2"></i> Speciality:</th>
                                <td>{{ optional($employee->doctor)->speciality ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th><i class="fas fa-graduation-cap text-primary me-2"></i> Qualification:</th>
                                <td>{{ optional($employee->doctor)->qualification ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th><i class="fas fa-file-invoice-dollar text-primary me-2"></i> Consultation Fee:</th>
                                <td>
                                    @if(optional($employee->doctor)->consultation_fee)
                                        ${{ number_format($employee->doctor->consultation_fee, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th><i class="fas fa-star text-primary me-2"></i> Rating:</th>
                                <td>
                                    @if(optional($employee->doctor)->rating)
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $employee->doctor->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                        @endfor
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endif

                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom: 10px;">
                        <i class="fas fa-align-left me-2 text-primary"></i> Short Biography
                    </h5>

                    <div class="mb-4 shadow-sm card rounded-3">
                        <div class="card-body" style="background-color: #ebeaea;">
                            <p class="mb-0" style="font-size: 15px; color: #333;">
                                {{ $employee->short_biography ? $employee->short_biography : 'No biography available yet.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ Route('clinic.view_employees') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
