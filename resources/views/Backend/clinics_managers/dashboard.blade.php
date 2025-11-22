@extends('Backend.clinics_managers.master')

@section('title' , 'Clinic Manager Dashboard')

@section('content')
    <div class="page-wrapper">
            <div class="content">

                {{-- Welcome --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm" style="
                        border-left: 5px solid #00A8FF;
                        border-radius: 12px;
                        overflow: hidden;
                    ">
                        <div class="card-body d-flex align-items-center" style="padding: 18px 24px;">

                            <div style="
                                width: 60px; height: 60px;
                                background: linear-gradient(135deg, #e6f4ff, #d4edff);
                                display: flex; align-items: center; justify-content: center;
                                border-radius: 50%;
                                color: #00A8FF;
                                font-size: 26px;
                                margin-right: 18px;
                                box-shadow: 0 3px 8px rgba(0,0,0,0.08);
                            ">
                                <i class="fas fa-handshake"></i>
                            </div>

                            <div>
                                <h4 style="
                                    margin: 0;
                                    font-weight: 700;
                                    color: #00A8FF;
                                    font-size: 24px;
                                ">
                                    Welcome {{ Auth::user()->name }}
                                </h4>

                                <p style="
                                    margin: 3px 0 0;
                                    color: #666;
                                    font-size: 15px;
                                ">
                                    We're glad to have you here today.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg4"><i class="fas fa-building" aria-hidden="true"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $department_count }}</h3>
                                <span class="widget-title4">Departments <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1" style="background-color: #4b5563;">
                                <i class="fas fa-user" aria-hidden="true"></i>
                            </span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $employee_count }}</h3>
                                <span class="widget-title1"  style="background-color: #4b5563;">Employees <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-user-md"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $doctor_count }}</h3>
                                <span class="widget-title2">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fas fa-user-injured" aria-hidden="true"></i></span>
                            <div class="text-right dash-widget-info">
                                <h3>{{ $patient_count }}</h3>
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
                                <h3>{{ $invoice_count }}</h3>
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
                                <a href="{{ route('clinic.view_appointments') }}" class="float-right btn btn-primary">View all</a>
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
                                                        @if($appointment->patient && $appointment->patient->user)
                                                            <a class="avatar"
                                                               href="{{ route('clinic.profile_patient', ['id' => $appointment->patient->id]) }}">
                                                                {{ substr($appointment->patient->user->name, 0, 1) }}
                                                            </a>
                                                        @else
                                                            <span class="avatar bg-danger text-white">?</span>
                                                        @endif
                                                        @if($appointment->patient && $appointment->patient->user)
                                                            <h2>
                                                                <a href="{{ route('clinic.profile_patient', ['id' => $appointment->patient->id]) }}">
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
                                                        <a href="{{ route('clinic.details_appointment', ['id' => $appointment->id]) }}"
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
                                                        <a href="{{ route('clinic.profile_doctor' , ['id' => $doctor->id]) }}" title="{{ $doctor->employee->user->name }}">
                                                            <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/user.jpg') }}" alt="" class="w-40 rounded-circle">
                                                            <span class="status online"></span>
                                                        </a>
                                                    </div>
                                                    <div class="contact-info">
                                                        <a href="{{ route('clinic.profile_doctor' , ['id' => $doctor->id]) }}"
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
                                <a href="{{ route('clinic.view_doctors') }}" class="text-muted">View all Doctors</a>
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
                                <a href="{{ route('clinic.view_patients') }}" class="float-right btn btn-primary">View all</a>
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
                                                            <a href="{{ route('clinic.profile_patient', ['id' => $patient->id]) }}"
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
