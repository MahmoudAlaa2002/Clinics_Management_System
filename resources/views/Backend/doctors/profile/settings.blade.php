@extends('Backend.doctors.master')

@section('title', 'Profile Settings')

@section('content')
<style>
    .card-box {
        border-radius: 15px;
        padding: 25px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .form-label i {
        color: #03A9F4;
    }

    .btn-rounded {
        border-radius: 25px;
        padding: 8px 25px;
    }

    .password-toggle {
        position: relative;
    }

    .password-toggle input {
        padding-right: 40px;
    }

    .password-toggle i.toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 16px;
    }

    .password-strength {
        height: 6px;
        border-radius: 5px;
        margin-top: 5px;
        background-color: #e0e0e0;
        position: relative;
    }

    .password-strength span {
        display: block;
        height: 100%;
        border-radius: 5px;
        transition: width 0.3s ease;
    }

    .strength-text {
        font-size: 13px;
        font-weight: 500;
        margin-left: 10px;
    }

    .strength-weak { width: 33%; background-color: #f44336; }
    .strength-medium { width: 66%; background-color: #ff9800; }
    .strength-strong { width: 100%; background-color: #4caf50; }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        color: #03A9F4;
        margin-bottom: 15px;
    }

    .form-check-label {
        margin-left: 8px;
        font-weight: 500;
    }

    .theme-select {
        max-width: 200px;
    }

    hr {
        margin: 30px 0;
        border-top: 1px solid #e0e0e0;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        {{-- Change Password --}}
        <div class="card-box">
            <h5 class="section-title"><i class="fa fa-lock me-2"></i> Change Password</h5>
            <form action="{{ route('doctor.profile.updatePassword') }}" method="POST">
                @csrf
                <div class="form-group mb-3 password-toggle">
                    <label class="form-label"><i class="fa fa-lock me-2"></i> Current Password</label>
                    <input type="password" name="current_password" class="form-control" id="current_password" required>
                    <i class="fa fa-eye toggle-password" toggle="#current_password"></i>
                </div>

                <div class="form-group mb-3 password-toggle">
                    <label class="form-label"><i class="fa fa-key me-2"></i> New Password</label>
                    <input type="password" name="password" class="form-control" id="new_password" required>
                    <i class="fa fa-eye toggle-password" toggle="#new_password"></i>
                    <div class="d-flex align-items-center mt-1">
                        <div class="password-strength flex-grow-1"><span id="strength-bar"></span></div>
                        <span class="strength-text" id="strength-text"></span>
                    </div>
                    <small class="form-text text-muted">Use at least 6 characters including letters and numbers.</small>
                </div>

                <div class="form-group mb-4 password-toggle">
                    <label class="form-label"><i class="fa fa-check me-2"></i> Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="confirm_password" required>
                    <i class="fa fa-eye toggle-password" toggle="#confirm_password"></i>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="fa fa-save me-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Email --}}
        <div class="card-box">
            <h5 class="section-title"><i class="fa fa-envelope me-2"></i> Change Email</h5>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">New Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $doctor->employee->user->email }}" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="fa fa-save me-1"></i> Update Email
                    </button>
                </div>
            </form>
        </div>

        {{-- Two-Factor Authentication --}}
        <div class="card-box">
            <h5 class="section-title"><i class="fa fa-shield-alt me-2"></i> Two-Factor Authentication (2FA)</h5>
            <form action="#" method="POST">
                @csrf
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="enable_2fa" id="enable_2fa" {{ $doctor->two_factor_enabled ? 'checked' : '' }}>
                    <label class="form-check-label" for="enable_2fa">Enable Two-Factor Authentication</label>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="fa fa-save me-1"></i> Save 2FA Settings
                    </button>
                </div>
            </form>
        </div>

        {{-- Notification & Privacy Settings --}}
        <div class="card-box">
            <h5 class="section-title"><i class="fa fa-sliders me-2"></i> Preferences</h5>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Notifications</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="notify_appointments" name="notify_appointments" {{ $doctor->notify_appointments ? 'checked' : '' }}>
                        <label class="form-check-label" for="notify_appointments">Appointment Notifications</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="notify_messages" name="notify_messages" {{ $doctor->notify_messages ? 'checked' : '' }}>
                        <label class="form-check-label" for="notify_messages">Message Notifications</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Visibility</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="profile_visible" name="profile_visible" {{ $doctor->employee->user->profile_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="profile_visible">Make profile visible to patients</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Language / Theme</label>
                    <select class="form-control theme-select" name="theme">
                        <option value="light" {{ $doctor->theme == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ $doctor->theme == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="fa fa-save me-1"></i> Save Preferences
                    </button>
                </div>
            </form>
        </div>

        {{-- Account Actions --}}
        <div class="card-box">
            <h5 class="section-title"><i class="fa fa-user-times me-2"></i> Account Actions</h5>
            <div class="d-flex justify-content-between">
                <form action="{{ route('doctor.profile.logoutOtherDevices') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log Out From Other Devices</button>
                </form>
                <a href="#" class="btn btn-warning btn-rounded"><i class="fa fa-trash-alt me-1"></i> Delete Account</a>
            </div>
        </div>

    </div>
</div>

<script>
    // Show/hide password
    document.querySelectorAll('.toggle-password').forEach(function(el){
        el.addEventListener('click', function(){
            let input = document.querySelector(this.getAttribute('toggle'));
            if(input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    // Password strength meter
    const newPassword = document.getElementById('new_password');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');

    newPassword.addEventListener('input', function() {
        const val = newPassword.value;
        let strength = 0;
        if(val.length >= 6) strength++;
        if(/[A-Z]/.test(val) && /[a-z]/.test(val)) strength++;
        if(/\d/.test(val)) strength++;
        if(/[!@#$%^&*]/.test(val)) strength++;

        if(strength <= 1) {
            strengthBar.className = 'strength-weak';
            strengthText.textContent = 'Weak';
            strengthText.style.color = '#f44336';
        } else if(strength === 2 || strength === 3) {
            strengthBar.className = 'strength-medium';
            strengthText.textContent = 'Medium';
            strengthText.style.color = '#ff9800';
        } else {
            strengthBar.className = 'strength-strong';
            strengthText.textContent = 'Strong';
            strengthText.style.color = '#4caf50';
        }

        if(val.length === 0) {
            strengthBar.className = '';
            strengthText.textContent = '';
        }
    });
</script>
@endsection
