@extends('auth.master')

@section('title' , 'Register')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background-color: #f4f7fe;
    }
    .register-container {
        margin-top: 60px;
        margin-bottom: 60px;
    }
    .card {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .card-title {
        font-weight: bold;
        font-size: 18px;
        color: #00A8FF;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-primary {
        background-color: #00A8FF;
        border: none;
    }
    .btn-primary:hover {
        background-color: #00A8FF;
    }
    .required {
        color: #dc3545;
        font-weight: bold;
    }

    /* ===== Gender Style ===== */
    .gender-wrapper {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        height: 38px;
    }
    .gender-wrapper label {
        margin-bottom: 0;
        font-weight: 500;
    }
</style>

<div class="container register-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="mb-4 text-center">
                <h2 class="fw-bold text-primary">
                    Create New Patient Account <i class="fa fa-user-plus"></i>
                </h2>
            </div>

            {{-- ================= BASIC INFORMATION ================= --}}
            <div class="p-4 card">
                <h5 class="mb-4 card-title">
                    <i class="fa fa-user"></i> Basic Information
                </h5>

                <div class="row g-4">

                    {{-- Full Name --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Full Name <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" id="name" class="form-control">
                        </div>
                    </div>

                    {{-- Date of Birth --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Date Of Birth <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar-days"></i></span>
                            <input type="date" id="date_of_birth" class="form-control">
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Phone <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            <input type="text" id="phone" class="form-control">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Email <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" class="form-control">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Password <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" id="password" class="form-control">
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Confirm Password <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-check-circle"></i></span>
                            <input type="password" id="password_confirmation" class="form-control">
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Address <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-location-dot"></i></span>
                            <input type="text" id="address" class="form-control">
                        </div>
                    </div>


                    {{-- Gender --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Gender <span class="required">*</span></label>
                        <div class="gender-wrapper">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Male">
                                <label class="form-check-label">
                                    <i class="fa fa-mars"></i> Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Female">
                                <label class="form-check-label">
                                    <i class="fa fa-venus"></i> Female
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ================= MEDICAL INFORMATION ================= --}}
            <div class="p-4 card">
                <h5 class="mb-4 card-title">
                    <i class="fa fa-notes-medical"></i> Medical Information
                </h5>

                <div class="row g-4">

                    {{-- Blood Type --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Blood Type</label>
                        <select id="blood_type" class="form-control">
                            <option value="" disabled selected hidden>Select Blood Type</option>
                            <option>A+</option><option>A-</option>
                            <option>B+</option><option>B-</option>
                            <option>AB+</option><option>AB-</option>
                            <option>O+</option><option>O-</option>
                        </select>
                    </div>

                    {{-- Emergency Contact --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Emergency Contact</label>
                        <input type="text" id="emergency_contact" class="form-control">
                    </div>

                    {{-- Allergies --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Allergies</label>
                        <textarea id="allergies" class="form-control" rows="2"></textarea>
                    </div>

                    {{-- Chronic Diseases --}}
                    <div class="col-md-6">
                        <label class="fw-bold">Chronic Diseases</label>
                        <textarea id="chronic_diseases" class="form-control" rows="2"></textarea>
                    </div>

                </div>
            </div>

            <button type="button" class="btn btn-primary w-100 registerBtn">
                Create Account
            </button>

            <div class="mt-3 text-center">
                <small>Already have an account?
                    <a href="{{ route('login') }}">Login here</a>
                </small>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    $('.registerBtn').click(function () {

        let gender = $('input[name="gender"]:checked').val();

        let data = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            phone: $('#phone').val(),
            address: $('#address').val(),
            date_of_birth: $('#date_of_birth').val(),
            gender: gender,
            blood_type: $('#blood_type').val(),
            emergency_contact: $('#emergency_contact').val(),
            allergies: $('#allergies').val(),
            chronic_diseases: $('#chronic_diseases').val(),
            _token: "{{ csrf_token() }}"
        };

        // ===== Required Fields Validation =====
        if (!data.name || !data.email || !data.password || !data.password_confirmation ||
            !data.phone || !data.address || !data.date_of_birth || !data.gender) {

            Swal.fire({
                title: 'Error!',
                text: 'Please fill in all required fields',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        // ===== Password Validation (6–15, numbers + symbols) =====
        let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

        if (data.password && !passwordPattern.test(data.password)){
                Swal.fire({
                    title: 'Invalid Password',
                    text: 'Password must be 6–15 characters',
                    icon: 'error',
                    confirmButtonColor: '#00A8FF'
                });
                return;
            }


        if (data.password !== data.password_confirmation) {
            Swal.fire({
                title: 'Error!',
                text: 'Passwords do not match',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        // ===== Real Email Validation (Laravel RFC + DNS) =====
        $.ajax({
            method: 'POST',
            url: "{{ route('check_email') }}",
            data: {
                email: data.email,
                _token: "{{ csrf_token() }}"
            },
            success: function () {

                // ===== Register Patient =====
                $.ajax({
                    method: 'POST',
                    url: "{{ route('register') }}",
                    data: data,
                    success: function (response) {

                        if (response.data == 0) {
                            Swal.fire({
                                title: 'Warning',
                                text: 'Email already exists',
                                icon: 'warning',
                                confirmButtonColor: '#00A8FF'
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Patient account has been created successfully',
                                icon: 'success',
                                confirmButtonColor: '#00A8FF'
                            }).then(() => {
                                window.location.href = '/patient/home';
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
</script>
@endsection

