@extends('Backend.master')

@section('title' , 'Edit Admin Profile')


@section('content')

<style>

    .col-sm-6 {
        margin-bottom: 20px;
    }

    input[type="date"] {
        direction: ltr;
        text-align: left;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Admin Profile</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_profile') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                </div>
                              <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ $user->date_of_birth }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="email" id="email" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Password </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password (optional)">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Confirm Password </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter new confirm password (optional)">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                </div>
                                <input class="form-control" type="text" id="address" name="address" value="{{ $user->address }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Avatar</label>
                                <div class="profile-upload">
                                    <div class="upload-img">
                                        <img alt="doctor image" src="{{ asset($user->image ?? 'assets/img/user.jpg') }}">
                                    </div>
                                    <div class="upload-input">
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group gender-select">
                                <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Admin Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let date_of_birth = $('#date_of_birth').val().trim();
                let email = $('#email').val();
                let password = $('#password').val();
                let confirm_password = $('#confirm_password').val();
                let phone = $('#phone').val().trim();
                let address = $('#address').val().trim();
                let gender = $('input[name="gender"]:checked').val();
                let image = document.querySelector('#image').files[0];


                if (name == '' || date_of_birth == '' || email == '' || phone == '' || address == '' || gender == undefined) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('gender', gender);
                if (image) {
                    formData.append('image', image);
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_profile') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function (response) {
                        if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Admin Profile Has Been Updated Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin/my_profile';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
