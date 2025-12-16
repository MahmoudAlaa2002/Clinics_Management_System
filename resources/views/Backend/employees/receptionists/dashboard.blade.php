@extends('Backend.employees.receptionists.master')

@section('title' , 'Receptionist Dashboard')

@section('content')

<style>
    .welcome-card {
        background: linear-gradient(135deg, #00A8FF, #00A8FF);
        border-radius: 18px;
        padding: 0;
        overflow: hidden;
        position: relative;
        box-shadow: 0 12px 28px rgba(0, 128, 255, 0.25);
        transition: 0.35s ease-in-out;
        width: 100%;
    }

    .welcome-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 32px rgba(0, 128, 255, 0.35);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        filter: blur(40px);
    }

    .welcome-content {
        display: flex;
        align-items: center;
        padding: 28px 32px;
        position: relative;
        z-index: 10;
    }

    .welcome-icon {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
        margin-right: 20px;
        backdrop-filter: blur(6px);
        border: 2px solid rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
        animation: pulseGlow 2.3s infinite ease-in-out;
    }

    @keyframes pulseGlow {
        0% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
        50% { box-shadow: 0 0 22px rgba(255,255,255,0.9); }
        100% { box-shadow: 0 0 12px rgba(255,255,255,0.5); }
    }

    .welcome-text h3 {
        margin: 0;
        color: #ffffff;
        font-weight: 800;
        font-size: 26px;
        letter-spacing: .5px;
    }

    .welcome-text p {
        margin: 6px 0 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 15px;
        font-weight: 400;
    }
</style>


<div class="page-wrapper">
    <div class="content">

        {{-- Welcome --}}
        <div class="row">
            <div class="col-12 mb-4 mt-2">
                <div class="welcome-card">
                    <div class="welcome-content">

                        <div class="welcome-icon">
                            <i class="fas fa-handshake"></i>
                        </div>

                        <div class="welcome-text">
                            <h3>Welcome, {{ Auth::user()->name }} 👋</h3>
                            <p>We hope you have a productive and wonderful day!</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fa fa-user-md"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $doctors_count }}</h3>
                        <span class="widget-title2">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg3"><i class="fas fa-user-injured" aria-hidden="true"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $patients_count }}</h3>
                        <span class="widget-title3">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2" style="background-color: #e83e8c;"><i class="fas fa-calendar-alt"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $all_appointments }}</h3>
                        <span class="widget-title2" style="background-color: #e83e8c;">All Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2" style="background-color: #6f42c1;"><i class="fas fa-calendar-day"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $today_appointments }}</h3>
                        <span class="widget-title2" style="background-color: #6f42c1;">Today Appointments <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <span class="dash-widget-bg2" style="background-color: #8B4513;"><i class="fas fa-file-invoice-dollar"></i></span>
                    <div class="text-right dash-widget-info">
                        <h3>{{ $invoices_count }}</h3>
                        <span class="widget-title2" style="background-color: #8B4513;">Invoices <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            {{-- Appointments View --}}
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Appointments</h4>
                        <a href="{{ route('receptionist.view_appointments') }}" class="float-right btn btn-primary">View all</a>
                    </div>

                    <div class="card-body p-0">
                        @if($appointments->isEmpty())
                            <div class="py-5 text-center">
                                <h5 style="color: #555; font-weight: 500;">There are currently no scheduled appointments</h5>
                            </div>
                        @else
                            <div class="table-responsive" style="min-height: 350px; max-height: 350px; overflow-y: auto;">
                                <table class="table mb-0">

                                    <thead class="d-none">
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Doctor Name</th>
                                            <th>Timing</th>
                                            <th class="text-right">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td style="min-width: 200px;">

                                                {{-- Avatar --}}
                                                @if($appointment->patient && $appointment->patient->user)
                                                    <a class="avatar"
                                                       href="{{ route('receptionist.profile_patient', ['id' => $appointment->patient->id]) }}">
                                                        {{ substr($appointment->patient->user->name, 0, 1) }}
                                                    </a>
                                                @else
                                                    <span class="avatar bg-danger text-white">?</span>
                                                @endif

                                                {{-- Patient Name + Address --}}
                                                @if($appointment->patient && $appointment->patient->user)
                                                    <h2>
                                                        <a href="{{ route('receptionist.profile_patient', ['id' => $appointment->patient->id]) }}">
                                                            {{ $appointment->patient->user->name }}
                                                            <span>{{ $appointment->patient->user->address ?? 'No address' }}</span>
                                                        </a>
                                                    </h2>
                                                @else
                                                    <h2>
                                                        <span class="text-danger">Deleted Patient</span>
                                                        <span class="d-block text-muted" style="font-size: 13px;">No address</span>
                                                    </h2>
                                                @endif

                                            </td>

                                            <td>
                                                <h5 class="p-0 time-title">Appointment With</h5>

                                                @if($appointment->doctor && $appointment->doctor->employee && $appointment->doctor->employee->user)
                                                    <p>Dr. {{ $appointment->doctor->employee->user->name }}</p>
                                                @else
                                                    <p class="text-danger">Doctor Deleted</p>
                                                @endif
                                            </td>

                                            <td>
                                                <h5 class="p-0 time-title">Timing</h5>
                                                <p>{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</p>
                                            </td>

                                            <td class="text-right">
                                                <a href="{{ route('receptionist.details_appointment', ['id' => $appointment->id]) }}"
                                                   class="btn btn-outline-primary take-btn">
                                                    Take up
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>



            {{-- Doctors View --}}
            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card member-panel">
                    <div class="bg-white card-header">
                        <h4 class="mb-0 card-title">Doctors</h4>
                    </div>
                    <div class="card-body">
                        @if($doctors->isEmpty())
                        <div class="text-center" style="padding: 100px 0;">
                            <h5 style="color: #555; font-weight: 500;">There are no doctors listed yet</h5>
                        </div>
                        @else
                            <ul class="contact-list">
                                @foreach ($doctors as $doctor)
                                    <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="{{ route('receptionist.profile_doctor' , ['id' => $doctor->id]) }}" title="{{ $doctor->employee->user->name }}">
                                                    <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/user.jpg') }}" alt="" class="w-40 rounded-circle">
                                                    <span class="status online"></span>
                                                </a>
                                            </div>
                                            <div class="contact-info">
                                                <a href="{{ route('receptionist.profile_doctor' , ['id' => $doctor->id]) }}"
                                                    class="contact-name text-ellipsis"
                                                    style="color: #00A8FF; font-weight: 600;">
                                                     {{ $doctor->employee->user->name }}
                                                 </a>
                                                <span class="contact-date">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $doctor->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="text-center bg-white card-footer">
                        <a href="{{ route('receptionist.view_doctors') }}" class="text-muted">View all Doctors</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Patients View --}}
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">New Patients</h4>
                        <a href="{{ route('receptionist.view_patients') }}" class="float-right btn btn-primary">View all</a>
                    </div>
                    <div class="card-block">
                        @if($patients->isEmpty())
                            <div class="text-center" style="padding: 100px 0;">
                                <h5 style="color: #555; font-weight: 500;">No patients available at the moment</h5>
                            </div>
                        @else
                            <div class="table-responsive" style="min-height: 350px; max-height: 350px; overflow-y: auto;">
                                <table class="table mb-0 new-patient-table">
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td>
                                                    <img width="34" height="34" class="rounded-circle" src="{{ asset($patient->user->image ?? 'assets/img/user.jpg') }}" alt="">
                                                    <h2>{{ $patient->user->name }}</h2>
                                                </td>
                                                <td>{{ $patient->user->email }}</td>
                                                <td>{{ $patient->user->phone }}</td>
                                                <td>
                                                    <a href="{{ route('receptionist.profile_patient', ['id' => $patient->id]) }}"
                                                       class="float-right border btn btn-primary btn-primary-one border-primary">
                                                       Show
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="notification-box">
        <div class="msg-sidebar notifications msg-noti">
            <div class="topnav-dropdown-header">
                <span>Messages</span>
            </div>
            <div class="drop-scroll msg-list-scroll" id="msg_list">
                <ul class="list-box">
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">R</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Richard Miles </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item new-message">
                                <div class="list-left">
                                    <span class="avatar">J</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">John Doe</span>
                                    <span class="message-time">1 Aug</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">T</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Tarah Shropshire </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">M</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Mike Litorus</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">C</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Catherine Manseau </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">D</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Domenic Houston </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">B</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Buster Wigton </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">R</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Rolland Webber </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">C</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Claire Mapes </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">M</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Melita Faucher</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">J</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Jeffery Lalor</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">L</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Loren Gatlin</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">T</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Tarah Shropshire</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="chat.html">See all messages</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
