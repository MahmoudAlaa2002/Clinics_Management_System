@extends('auth.master')

@section('title', 'Forgot Password')

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
                <h2 class="clinic-title">Forgot Password</h2>
                <p class="text-muted-small">
                    Enter your email and we’ll send you a reset link
                </p>
            </div>

            <div class="p-4 card">

                <div class="mb-3 text-center account-logo">
                    <img src="{{ asset('assets/img/logo-dark.png') }}" width="50" height="50" alt="">
                </div>

                {{-- Success Message --}}
                @if (session('status'))
                    <div class="text-center alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="text-center alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password_email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 forgotPassword">
                        <span class="spinner-border spinner-border-sm d-none me-2"></span>
                        <span class="btn-text">Send Reset Link</span>
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

            $('.forgotPassword').click(function (e) {
                e.preventDefault();

                let button = $(this);
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');

                let email = $('#email').val().trim();

                // 1️⃣ الحقل فارغ
                if (email === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please enter your email',
                        confirmButtonColor: '#007BFF'
                    });
                    return;
                }

                // ⏳ تفعيل التحميل
                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Sending...');

                $.ajax({
                    method: 'POST',
                    url: "{{ route('password_email') }}",
                    data: {
                        email: email,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function (response) {

                        // 3️⃣ نجاح
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Reset link has been sent to your email',
                            confirmButtonColor: '#007BFF'
                        });

                        $('#email').val('');
                    },

                    error: function (xhr) {

                        // 2️⃣ إيميل غير صالح أو غير موجود
                        if (xhr.status === 422) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Invalid email address',
                                confirmButtonColor: '#007BFF'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong, please try again',
                                confirmButtonColor: '#007BFF'
                            });
                        }
                    },

                    complete: function () {
                        // 🔄 إعادة الزر لوضعه الطبيعي
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Send Reset Link');
                    }

                });
            });

        });
    </script>
@endsection

