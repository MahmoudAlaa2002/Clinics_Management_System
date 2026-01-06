@extends('Backend.admin.master')

@section('title' , 'Add New Patient')

@section('content')

<style>
    .col-sm-6{ margin-bottom:20px; }
    input[type="date"]{ direction:ltr; text-align:left; }
    .card + .card{ margin-top:20px; }
    .card-header{ font-weight:600; }

    .card {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
        overflow: hidden !important;
    }

    .card-header {
        background-color: #00A8FF !important; /* اللون الأزرق المطلوب */
        color: #fff !important; /* النص أبيض */
        font-weight: 600 !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        border-bottom: 1px solid #ddd !important;
    }

    .card-body {
        background-color: #fff;
        padding: 20px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Patient</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_patient') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- 1) Patient Info --}}
                    <div class="card">
                        <div class="card-header">Patient Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" id="email" name="email">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" type="password" id="password" name="password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" type="password" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="address" name="address">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <div class="profile-upload">
                                            <div class="upload-img">
                                                <img alt="" src="{{ asset('assets/img/user.jpg') }}">
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
                                                <input type="radio" id="gender" name="gender" class="form-check-input" value="Male">Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" id="gender" name="gender" class="form-check-input" value="Female">Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Medical Info --}}
                    <div class="card">
                        <div class="card-header">Medical Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Blood Type <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                        </div>
                                        <select class="form-control" id="blood_type" name="blood_type" required>
                                            <option value="" disabled selected>Select Blood Type</option>
                                            <option value="A+">A+</option><option value="A-">A-</option>
                                            <option value="B+">B+</option><option value="B-">B-</option>
                                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                                            <option value="O+">O+</option><option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Emergency Contact <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Allergies</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="allergies" name="allergies">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Chronic Diseases</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="chronic_diseases" name="chronic_diseases">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-t-20" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform:none !important;">
                            Add Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function isValidSelectValue(selectId) {      // هذا الميثود حتى أتجنب خداع الفيكفيار
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

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
                let blood_type = $('#blood_type').val();
                let emergency_contact = $('#emergency_contact').val();
                let allergies = $('#allergies').val();
                let chronic_diseases = $('#chronic_diseases').val();
                let gender = $('input[name="gender"]:checked').val();
                let image = document.querySelector('#image').files[0];


                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('blood_type', blood_type);
                formData.append('emergency_contact', emergency_contact);
                formData.append('allergies', allergies);
                formData.append('chronic_diseases', chronic_diseases);
                formData.append('gender', gender);
                if (image) {
                    formData.append('image', image);
                }

                let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

                // 1️⃣ فحص الحقول الأساسية
                if (name == '' || date_of_birth == '' || email == '' || password == '' || confirm_password == '' || phone == ''
                    || address == '' || gender === undefined || !isValidSelectValue('blood_type') || emergency_contact == '' ) {

                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter all required fields',
                        icon: 'error',
                        confirmButtonColor: '#00A8FF',
                    });
                    return;
                }

                // 2️⃣ فحص كلمة المرور
                if (!passwordPattern.test(password)) {
                    Swal.fire({
                        title: 'Invalid Password',
                        text: 'Password must be 6–15 characters',
                        icon: 'error',
                        confirmButtonColor: '#00A8FF'
                    });
                    return;
                }

                if (password !== confirm_password) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password confirmation does not match',
                        icon: 'error',
                        confirmButtonColor: '#00A8FF',
                    });
                    return;
                }

                // 3️⃣ فحص الإيميل الحقيقي من Laravel
                $.ajax({
                    method: 'POST',
                    url: "{{ route('check_email') }}",
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {

                        // 4️⃣ إذا الإيميل صالح → نحفظ المريض
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('store_patient') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.data == 0) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'This email is already used by another user',
                                        icon: 'error',
                                        confirmButtonColor: '#00A8FF',
                                    });
                                } else if (response.data == 1) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Patient has been added successfully',
                                        icon: 'success',
                                        confirmButtonColor: '#00A8FF',
                                    }).then(() => {
                                        window.location.href = '/admin/view/patients';
                                    });
                                }
                            }
                        });

                    },
                    error: function (xhr) {
                        let msg = 'Invalid email address';

                        if (xhr.responseJSON?.errors?.email) {
                            msg = xhr.responseJSON.errors.email[0];
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: msg,
                            icon: 'error',
                            confirmButtonColor: '#00A8FF'
                        });
                    }
                });

            });
        });



        $('#image').on('change', function (e) {
            const file = e.target.files[0];

            if (file) {
                const previewUrl = URL.createObjectURL(file);
                $('.profile-upload .upload-img img').attr('src', previewUrl);
            }
        });

    </script>
@endsection
