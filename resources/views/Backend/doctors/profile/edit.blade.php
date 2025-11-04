@extends('Backend.doctors.master')

@section('title', 'Edit Profile')

@section('content')
<style>
    .profile-card {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: auto;
    }
    .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #03A9F4;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: 600;
    }
    .btn-rounded {
        border-radius: 25px;
        padding: 8px 25px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h4 class="page-title"><i class="fa fa-user-edit text-primary me-2"></i> Edit Profile</h4>
            </div>
        </div>

        <div class="profile-card">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Profile Image --}}
                <div class="text-center mb-4">
                    <img src="{{ $doctor->employee->user->image ? asset($doctor->employee->user->image) : asset('assets/img/default-user.png') }}"
                        alt="Doctor"
                        class="profile-image">
                </div>

                {{-- User Information --}}
                <h5 class="mb-3"><i class="fa fa-info-circle me-1 text-primary"></i> Personal Info</h5>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->employee->user->name) }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->employee->user->email) }}" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->employee->user->phone) }}">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $doctor->employee->user->address) }}">
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control">
                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Doctor Information --}}
                <h5 class="mb-3 mt-4"><i class="fa fa-user-md me-1 text-primary"></i> Doctor Info</h5>

                <div class="mb-3">
                    <label class="form-label">Specialization</label>
                    <input type="text" name="speciality" class="form-control" value="{{ old('speciality', $doctor->speciality) }}">
                    @error('speciality') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $doctor->qualification) }}">
                    @error('qualification') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Consultation Fee ($)</label>
                    <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
                    @error('consultation_fee') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('doctor_dashboard') }}" class="btn btn-outline-secondary btn-rounded">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="fa fa-save me-1"></i> Update Profile
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
