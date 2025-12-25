@extends('auth.master')

@section('title', 'Reset Password')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background-color: #f4f7fe;
    }
    .login-container {
        margin-top: 80px;
    }
    .card {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .clinic-title {
        font-weight: bold;
        font-size: 24px;
        color: #007bff;
    }
    .text-muted-small {
        font-size: 14px;
        color: #6c757d;
    }
</style>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="mb-4 text-center">
                <h2 class="clinic-title">Reset Password</h2>
                <p class="text-muted-small">Enter your new password below</p>
            </div>

            <div class="p-4 card">

                <div class="mb-3 text-center">
                    <img src="{{ asset('assets/img/logo-dark.png') }}" width="50" height="50" alt="">
                </div>

                {{-- RESET FORM --}}
                <form id="resetForm">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ $email ?? '' }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Enter new password">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 resetBtn">
                        <span class="spinner-border spinner-border-sm d-none me-2"></span>
                        <span class="btn-text">Reset Password</span>
                    </button>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Back to Login
                        </a>
                    </div>
                </form>

            </div>

            <div class="mt-3 text-center">
                <small>&copy; {{ date('Y') }} Clinics Management System</small>
            </div>

        </div>
    </div>
</div>

@endsection


@section('js')
<script>
$(document).ready(function () {

    $('.resetBtn').click(function () {

        let button = $(this);
        let spinner = button.find('.spinner-border');
        let btnText = button.find('.btn-text');

        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="password_confirmation"]').val();
        let token = $('input[name="token"]').val();

        let passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

        if (!password || !confirmPassword) {
            Swal.fire({
                title: 'Error!',
                text: 'Please fill in all required fields',
                icon: 'error',
                confirmButtonColor: '#007BFF'
            });
            return;
        }

        if (!passwordPattern.test(password)) {
            Swal.fire({
                title: 'Invalid Password',
                text: 'Password must be 6–15 characters',
                icon: 'error',
                confirmButtonColor: '#007BFF'
            });
            return;
        }

        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Passwords do not match',
                confirmButtonColor: '#007BFF'
            });
            return;
        }

        button.prop('disabled', true);
        spinner.removeClass('d-none');
        btnText.text('Processing...');

        $.ajax({
            url: "{{ route('password.update') }}",
            method: "POST",
            data: {
                email: email,
                password: password,
                password_confirmation: confirmPassword,
                token: token,
                _token: "{{ csrf_token() }}"
            },

            success: function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Password reset successfully',
                    confirmButtonColor: '#007BFF'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
            },

            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid token or email',
                    confirmButtonColor: '#007BFF'
                });
            },

            complete: function () {
                button.prop('disabled', false);
                spinner.addClass('d-none');
                btnText.text('Reset Password');
            }
        });

    });

});
</script>
@endsection
