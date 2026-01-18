@extends('Backend.patients.master')

@section('title', 'Settings')

@section('content')

<style>

    .page-title{
        font-weight:700;
        color:#00A8FF;
    }

    .card-custom{
        border-radius:16px;
        border:1px solid #e6ecf3;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
    }

    .card-custom .card-header{
        background:#f7faff;
        border-bottom:1px solid #e6ecf3;
        font-weight:600;
    }

    .profile-img{
        width:120px;
        height:120px;
        border-radius:50%;
        object-fit:cover;
        border:3px solid #eaeaea;
    }

    .badge-status{
        background:#28a745;
    }

    .setting-item{
        padding:14px 12px;
        border-radius:10px;
        border:1px solid #e6ecf3;
        transition:.2s;
        cursor:pointer;
    }

    .setting-item:hover{
        background:#f7faff;
        transform:translateY(-2px);
    }

    .icon{
        width:40px;
        height:40px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#00A8FF;
        color:white;
    }


    .btn-outline-primary {
        border-color: #00A8FF !important;
        color: #00A8FF !important;
    }

    .btn-outline-primary:hover {
        background-color: #00A8FF !important;
        color: #fff !important;
    }

    .my-appointments-link,
    .my-invoices-link,
    .my-notifications-link,
    .pass-sec,
    .support,
    .chats{
        color: #0f172a;
        font-weight: 700;
        text-decoration: none;
    }

    .my-appointments-link:hover,
    .my-invoices-link:hover,
    .my-notifications-link:hover,
    .pass-sec:hover,
    .support:hover,
    .chats:hover{
        color: #00A8FF;
        text-decoration: none;
    }

</style>



<main class="main">
<div class="container mt-5 mb-5">

    <h2 class="page-title mb-4">Welcome Back 👋</h2>

    <div class="row gy-4">

        {{-- PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card card-custom">

                <div class="card-header" style="text-align: center;">
                    My Profile
                </div>

                <div class="card-body text-center">

                    <img src="{{ asset(auth()->user()->image ?? 'assets/img/user.jpg') }}" class="profile-img mb-3">

                    <h5>{{ auth()->user()->name ?? 'Patient Name' }}</h5>

                    <span class="badge badge-status mb-2">Active Patient</span>

                    <p class="text-muted mb-3">
                        {{ auth()->user()->email ?? 'email@example.com' }}
                    </p>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('patient.view_profile') }}" class="btn btn-outline-primary px-3">
                            View Profile
                        </a>

                        <a href="{{ route('patient.edit_profile') }}" class="btn btn-outline-primary px-4">
                            Edit Profile
                        </a>
                    </div>

                </div>

            </div>
        </div>


        {{-- DASHBOARD SUMMARY --}}
        <div class="col-lg-8">
            <div class="card card-custom">

                <div class="card-header" style="text-align: center;">
                    Quick Overview
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="setting-item">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="icon"><i class="fa-solid fa-calendar-check"></i></div>
                                    <div>
                                        <a href="{{ route('patient.myAppointments') }}" class="my-appointments-link">
                                            My Appointments
                                        </a>
                                        <p class="m-0 text-muted">View & manage</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                                    <div>
                                        <a href="{{ route('patient.invoices_view') }}" class="my-invoices-link">
                                            My Invoices
                                        </a>
                                        <p class="m-0 text-muted">History & payments</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="icon"><i class="fa-solid fa-bell"></i></div>
                                    <div>
                                        <a href="{{ route('notifications_index') }}" class="my-notifications-link">
                                            Notifications
                                        </a>
                                        <p class="m-0 text-muted">Reminders & updates</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- SECURITY & SETTINGS --}}
            <div class="card card-custom mt-4">

                <div class="card-header" style="text-align: center;">
                    Account Settings
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="setting-item">
                                <a href="{{ route('patient.edit_password') }}" class="pass-sec">Password & Security</a>
                                <p class="text-muted m-0">Change password & login protection</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <a href="{{ route('chat_contacts') }}" class="chats">Chats</a>
                                <p class="text-muted m-0">Contact support</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <a href="{{ route('patient.support') }}" class="support">Support</a>
                                <p class="text-muted m-0">Contact support</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
</main>

@endsection
