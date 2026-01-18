@extends('auth.master')

@section('title' , 'Login')

@section('content')
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css') }}" rel="stylesheet">
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
            background-color: #00A8FF;
            border: none;
        }
        .btn-primary:hover {
            background-color: #00A8FF;
        }
        .clinic-title {
            font-weight: bold;
            font-size: 24px;
            color: #00A8FF;
        }
    </style>

    <body>
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="mb-4 text-center">
                        <h2 class="clinic-title">Login</h2>
                    </div>
                    <div class="p-4 card">
                        <form method="POST" action="{{ route('user_login') }}">
                            @csrf

                            <div class="account-logo" style="text-align: center;">
                                <img src="{{asset('assets/img/logo-dark.png')}}" width="50px" height="50px" alt="">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
                                </div>
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="mb-0 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                                <a href="{{ route('password_request') }}" class="text-decoration-none">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 loginBtn">Login</button>

                            <div class="mt-3 text-center">
                                <span style="color: black;">Don't have an account? </span>
                                <a href="{{ route('register') }}" class="text-decoration-none" style="color: #00A8FF;">Register</a>
                            </div>
                        </form>
                    </div>
                    <div class="mt-3 text-center">
                        <small>&copy; {{ date('Y') }} Clinics Management System</small>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.loginBtn').click(function (e) {
            e.preventDefault();

            let email = $('#email').val();
            let password = $('#password').val();
            let remember = $('#remember').is(':checked');


            // ميثود لإظهار شاشة الخطأ في حال لم توجد قيمة للايميل أو الباسوورد
            if (email == '' || password == '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter Your Email & Password',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00A8FF',
                });
            } else {
                $.ajax({
                    method: 'post',
                    url: "{{ route('user_login') }}",
                    data: {
                        email: email,
                        password: password,
                        remember: remember
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        if (response.data === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Invalid Email or Password',
                                confirmButtonColor: '#00A8FF'
                            });

                        } else if (response.data === 1) {
                            window.location.href = '/admin/dashboard';

                        } else if (response.data === 2) {
                            window.location.href = '/clinic-manager/dashboard';

                        } else if (response.data === 3) {
                            window.location.href = '/department-manager/dashboard';

                        } else if (response.data === 4) {
                            window.location.href = '/doctor/dashboard';

                        } else if (response.data === 5) {
                            let position = response.position;

                            if (position === 'Receptionist') {
                                window.location.href = '/employee/receptionist/dashboard';
                            } else if (position === 'Nurse') {
                                window.location.href = '/employee/nurse/dashboard';
                            } else if (position === 'Accountant') {
                                window.location.href = '/employee/accountant/dashboard';
                            }

                        } else if (response.data === 6) {
                            window.location.href = '/patient/home';

                        } else {
                            Swal.fire('Error', 'Unexpected response from server', 'error');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection












