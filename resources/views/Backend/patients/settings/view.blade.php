@extends('Backend.patients.master')

@section('title', 'Settings')

@section('content')

<style>

    .page-title{
        font-weight:700;
        color:#007BFF;
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
        background:#007BFF;
        color:white;
    }

</style>


<main class="main">
<div class="container mt-5 mb-5">

    <h2 class="page-title mb-4">Welcome Back 👋</h2>

    <div class="row gy-4">

        {{-- PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card card-custom">

                <div class="card-header">
                    My Profile
                </div>

                <div class="card-body text-center">

                    <img src="{{ asset(auth()->user()->image ?? 'assets/img/user.jpg') }}" class="profile-img mb-3">

                    <h5>{{ auth()->user()->name ?? 'Patient Name' }}</h5>

                    <span class="badge badge-status mb-2">Active Patient</span>

                    <p class="text-muted mb-3">
                        {{ auth()->user()->email ?? 'email@example.com' }}
                    </p>

                    {{-- 🔹 الزرين جنب بعض --}}
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

                <div class="card-header">
                    Quick Overview
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="setting-item">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="icon"><i class="fa-solid fa-calendar-check"></i></div>
                                    <div>
                                        <strong>My Appointments</strong>
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
                                        <strong>My Invoices</strong>
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
                                        <strong>Notifications</strong>
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

                <div class="card-header">
                    Account Settings
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="setting-item">
                                <strong>Password & Security</strong>
                                <p class="text-muted m-0">Change password & login protection</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <strong>Privacy Control</strong>
                                <p class="text-muted m-0">Manage your data visibility</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="setting-item">
                                <strong>Support</strong>
                                <p class="text-muted m-0">Contact clinic support</p>
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
