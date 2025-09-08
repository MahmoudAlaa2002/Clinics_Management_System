@extends('Backend.admin.master')

@section('title' , 'My Profile')

@section('content')
<style>
    .profile-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #03A9F4;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .profile-section-title {
        font-weight: bold;
        color: #03A9F4;
        margin-bottom: 10px;
    }

    .profile-item i {
        color: #03A9F4;
        width: 25px;
    }

    .back-btn {
        background-color: #03A9F4;
        color: white;
        border-radius: 50px;
        padding: 8px 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0288d1;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div>
            <div >
                <h4 class="page-title">My Profile</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-4 profile-card">
                    <div class="mb-4 text-center">
                        <img src="{{ asset($user->image) }}" alt="Admin Image"
                            class="profile-image img-fluid rounded-circle" style="width: 150px; height:150px;">
                            <h2 class="mt-3 mb-0">{{ $user->name }}</h2>
                        <p class="text-muted">admin</p>
                    </div>

                    <hr>
                    <h5 class="fw-bold text-primary" style="font-size: 18px; margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> General Information
                    </h5>
                    <div class="mb-4 row" style="margin-left:5px;">

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-envelope me-2 text-primary"></i>
                            <strong>Email :</strong>&nbsp;
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-calendar me-2 text-primary"></i>
                            <strong>Birth Date:</strong>&nbsp;
                            <span class="text-muted">{{ $user->date_of_birth }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fa fa-phone me-2 text-primary"></i>
                            <strong>Phone :</strong>&nbsp;
                            <span class="text-muted">{{ $user->phone ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                            <strong>Gender:</strong>&nbsp;
                            <span class="text-muted">{{ ucfirst($user->gender) }}</span>
                        </div>

                        <div class="mb-3 col-md-6 profile-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            <strong>Address :</strong>&nbsp;
                            <span class="text-muted">{{ $user->address }}</span>
                        </div>

                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end" style="margin-top:15px;">
                    <a href="{{ Route('dashboard') }}" class="btn btn-primary rounded-pill" style="font-weight: bold;">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
