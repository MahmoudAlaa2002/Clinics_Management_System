@extends('Backend.doctors.master')

@section('title', 'Edit Profile')

@section('content')
    <style>
        body {
            background-color: #f6f9fc;
        }

        .profile-card {
            background: linear-gradient(145deg, #ffffff, #f0f9ff);
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 40px auto;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .profile-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #03A9F4;
            box-shadow: 0 6px 18px rgba(3, 169, 244, 0.3);
            transition: transform 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .profile-header h4 {
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }

        .form-section {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-section h5 {
            font-weight: 600;
            color: #03A9F4;
            margin-bottom: 20px;
            border-left: 4px solid #03A9F4;
            padding-left: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-rounded {
            border-radius: 25px;
            padding: 10px 28px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #03A9F4;
            border-color: #03A9F4;
        }

        .btn-primary:hover {
            background-color: #0288d1;
        }

        .btn-outline-secondary {
            border: 1px solid #bbb;
            color: #555;
        }

        .btn-outline-secondary:hover {
            background-color: #f0f0f0;
            border-color: #aaa;
        }

        .back-btn {
            background-color: #03A9F4;
            color: white;
            border-radius: 30px;
            padding: 10px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(3, 169, 244, 0.2);
        }

        .back-btn:hover {
            background-color: #0288d1;
            box-shadow: 0 6px 18px rgba(2, 136, 209, 0.3);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            font-weight: 500;
        }

        .page-title i {
            color: #03A9F4;
        }
    </style>

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="p-4 rounded-4"
                        style="background: linear-gradient(135deg, #03A9F4, #81D4FA);
                    color: white;
                    box-shadow: 0 6px 20px rgba(3, 169, 244, 0.25);
                    border-radius: 15px;">
                        <h2 class="mb-2" style="font-weight: 700;">Profile Settings</h2>
                        <p class="mb-0" style="font-size: 15px; opacity: 0.9;">
                            Manage your personal and professional information to keep your profile up to date.
                        </p>
                    </div>
                </div>
            </div>

            <div class="profile-card">

                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Profile Image & Name --}}
                    <div class="mb-5 text-center position-relative">
                        <div class="p-5 rounded-4"
                            style="background: linear-gradient(145deg, #f5faff 0%, #e3f2fd 100%);
                                border: 1px solid #d0e7fb;
                                box-shadow: 0 8px 20px rgba(3, 169, 244, 0.15);
                                position: relative;
                                overflow: hidden;">
                            <div class="position-relative d-inline-block">
                                <div style="position: relative; display: inline-block;">
                                    <img src="{{ asset($doctor->employee->user->image ?? 'assets/img/default-user.png') }}"
                                        alt="Doctor Image" class="img-fluid rounded-circle"
                                        style="width: 140px; height: 140px; object-fit: cover;
                                            border: 5px solid #fff;
                                            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
                                            background: #fff;">
                                    <span class="position-absolute bottom-0 end-0 translate-middle badge rounded-circle"
                                        style="background:#03A9F4; padding:10px; border:3px solid #fff;">
                                        <i class="fa fa-stethoscope text-white"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h2 class="mb-0" style="font-weight:700; color:#222;">{{ $doctor->employee->user->name }}
                                </h2>
                                <p class="text-muted" style="font-size:15px; margin-bottom: 0;">
                                    {{ ucfirst($doctor->speciality ?? 'Doctor') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Personal Info --}}
                    <div class="form-section">
                        <h5><i class="fa fa-info-circle me-1"></i> Personal Information</h5>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $doctor->employee->user->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $doctor->employee->user->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $doctor->employee->user->phone) }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $doctor->employee->user->address) }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-muted">Accepted formats: JPG, PNG, JPEG</small>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Doctor Info --}}
                    <div class="form-section">
                        <h5><i class="fa fa-user-md me-1"></i> Professional Details</h5>

                        <div class="mb-3">
                            <label class="form-label">Specialization</label>
                            <input type="text" name="speciality" class="form-control"
                                value="{{ old('speciality', $doctor->speciality) }}">
                            @error('speciality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control"
                                value="{{ old('qualification', $doctor->qualification) }}">
                            @error('qualification')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Consultation Fee ($)</label>
                            <input type="number" step="0.01" name="consultation_fee" class="form-control"
                                value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                            @error('consultation_fee')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ url()->previous() }}" class="btn back-btn">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn back-btn"
                            style="background-color: #03A9F4; border-color: #03A9F4;">
                            <i class="fa fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
