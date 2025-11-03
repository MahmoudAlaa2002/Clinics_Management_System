@extends('Backend.doctors.master')

@section('title', 'Profile Settings')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row mb-4">
            <div class="col-sm-12">
                <h4 class="page-title"><i class="fa fa-cogs text-primary me-2"></i> Change Password</h4>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-box" style="border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:25px; background:#fff;">
            <form action="{{ route('doctor.profile.updatePassword') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label class="form-label"><i class="fa fa-lock text-primary me-2"></i> Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label"><i class="fa fa-key text-primary me-2"></i> New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label"><i class="fa fa-check text-primary me-2"></i> Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="border-radius:25px; padding:8px 25px;">
                        <i class="fa fa-save me-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
