@extends('auth.master')

@section('title' , 'Register')

@section('content')
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fe;
        }
        .register-container {
            margin-top: 60px;
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
    </style>

<body>
    <div class="container mb-5 register-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-4 text-center">
                    <h2 class="clinic-title">Create New Account <i class="fa fa-user-plus me-2"></i></h2>
                </div>
                <div class="p-4 card">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="account-logo" style="text-align: center;">
                            <img src="{{asset('assets/img/logo-dark.png')}}" width="50px" height="50px" alt="">
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <div class="input-group">
                              <span class="input-group-text text-muted">
                                <i class="fa fa-user"></i>
                              </span>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                              <span class="input-group-text text-muted">
                                <i class="fa fa-envelope"></i>
                              </span>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                            </div>
                          </div>


                          <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                              <span class="input-group-text text-muted">
                                <i class="fa fa-lock"></i>
                              </span>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
                            </div>
                          </div>


                          <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <div class="input-group">
                              <span class="input-group-text text-muted">
                                <i class="fa fa-check-circle"></i>
                              </span>
                              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">
                            </div>
                          </div>


                          <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <div class="input-group">
                              <span class="input-group-text text-muted">
                                <i class="fa fa-phone"></i>
                              </span>
                              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
                            </div>
                          </div>

                        <button type="submit" class="btn btn-primary w-100 newAccount">Register</button>
                    </form>
                </div>
                <div class="mt-3 text-center">
                    <small>Already have an account? <a href="{{ route('login') }}">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection



@section('js')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        $('.newAccount').click(function(e){
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();
            let phone = $('#phone').val();

            if (name == '' || email == '' || password == '' || password_confirmation == '' || phone == '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please fill in all required fields',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else if (password !== password_confirmation) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The Password And Confirmation Password Do Not Match',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                $.ajax({
                    method: 'post',
                    url: "{{ route('register') }}",
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        phone:phone
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        if(response.data == 0){
                            Swal.fire({
                            title: 'Warning!',
                            text: 'Sorry , This Email Already Exists',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        }else if(response.data == 1){
                            let userId = response.user_id;
                            Swal.fire({
                                title: 'Success',
                                text: 'Account Has Been Created Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/patient/dashboard/' + userId;
                            });
                        }
                    },
                });
            }
        });
    });
</script>
@endsection



