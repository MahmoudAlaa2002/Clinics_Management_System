@extends('Backend.admin.master')

@section('title' , 'Edit Patient')

@section('content')

    <style>
        .col-sm-6 { margin-bottom: 20px; }
        input[type="date"] { direction: ltr; text-align: left; }
        .card + .card { margin-top: 20px; }
        .card-header { font-weight: 600; }

        .card {
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
            overflow: hidden !important;
        }

        .card-header {
            background-color: #00A8FF !important;
            color: #fff !important;
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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Patient</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_patient', ['id' => $patient->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1) Patient Info --}}
                        <div class="card">
                            <div class="card-header">Patient Information</div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-sm-6">
                                        <label>Patient Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $patient->user->name }}">
                                        </div>
                                    </div>
                                    {{-- Date of Birth --}}
                                    <div class="col-sm-6">
                                        <label>Date of Birth <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ $patient->user->date_of_birth }}">
                                        </div>
                                    </div>
                                    {{-- Phone --}}
                                    <div class="col-sm-6">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $patient->user->phone }}">
                                        </div>
                                    </div>
                                    {{-- Email --}}
                                    <div class="col-sm-6">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $patient->user->email }}">
                                        </div>
                                    </div>
                                    {{-- Password --}}
                                    <div class="col-sm-6">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                                        </div>
                                    </div>
                                    {{-- Confirm Password --}}
                                    <div class="col-sm-6">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                                        </div>
                                    </div>
                                    {{-- Address --}}
                                    <div class="col-sm-6">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ $patient->user->address }}">
                                        </div>
                                    </div>
                                    {{-- Avatar --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Avatar</label>
                                            <div class="profile-upload">
                                                <div class="upload-img">
                                                    <img alt="patient image" src="{{ asset($patient->user->image ?? 'assets/img/user.jpg') }}">
                                                </div>
                                                <div class="upload-input">
                                                    <input type="file" class="form-control" id="image" name="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Gender --}}
                                    <div class="col-sm-6">
                                        <div class="form-group gender-select">
                                            <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="gender" value="male" class="form-check-input" {{ $patient->user->gender == 'male' ? 'checked' : '' }}>Male
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" name="gender" value="female" class="form-check-input" {{ $patient->user->gender == 'female' ? 'checked' : '' }}>Female
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
                                    {{-- Blood Type --}}
                                    <div class="col-sm-6">
                                        <label>Blood Type <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                            </div>
                                            <select class="form-control" id="blood_type" name="blood_type">
                                                <option value="" disabled>Select Blood Type</option>
                                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                                                    <option value="{{ $type }}" {{ $patient->blood_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Emergency Contact --}}
                                    <div class="col-sm-6">
                                        <label>Emergency Contact <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $patient->emergency_contact }}">
                                        </div>
                                    </div>

                                    {{-- Allergies --}}
                                    <div class="col-sm-6">
                                        <label>Allergies</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="allergies" name="allergies" value="{{ $patient->allergies }}">
                                        </div>
                                    </div>

                                    {{-- Chronic Diseases --}}
                                    <div class="col-sm-6">
                                        <label>Chronic Diseases</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="chronic_diseases" name="chronic_diseases" value="{{ $patient->chronic_diseases }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="text-center m-t-20" style="margin-top:20px;">
                            <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">Edit Patient</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function isValidSelectValue(selectId) {
        let val = $(`#${selectId}`).val();
        return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
    }

    $(document).ready(function () {
        $('.editBtn').click(function (e) {
            e.preventDefault();

            let name = $('#name').val()?.trim() || '';
            let date_of_birth = $('#date_of_birth').val()?.trim() || '';
            let email = $('#email').val()?.trim() || '';
            let password = $('#password').val() || '';
            let confirm_password = $('#confirm_password').val() || '';
            let phone = $('#phone').val()?.trim() || '';
            let address = $('#address').val()?.trim() || '';
            let gender = $('input[name="gender"]:checked').val();
            let short_biography = $('#short_biography').val()?.trim() || '';
            let status = $('input[name="status"]:checked').val();
            let image = document.querySelector('#image')?.files[0];

            // الحقول الطبية
            let blood_type = $('#blood_type').val();
            let emergency_contact = $('#emergency_contact').val()?.trim() || '';
            let allergies = $('#allergies').val()?.trim() || '';
            let chronic_diseases = $('#chronic_diseases').val()?.trim() || '';

            let formData = new FormData();
            formData.append('_method', 'PUT');
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

            // التحقق من الحقول المطلوبة
            if (!name || !date_of_birth || !email || !phone || !address || !gender ||
                !isValidSelectValue('blood_type') || !emergency_contact) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter All Required Fields.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#007BFF',
                });
                return;
            }

            // التحقق من تطابق كلمة المرور
            if (password && password !== confirm_password) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Password confirmation does not match',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#007BFF',
                });
                return;
            }

            $.ajax({
                method: 'POST',
                url: "{{ route('update_patient', ['id' => $patient->id]) }}",
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
                            text: 'The patient already exists',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                    } else if (response.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Patient has been updated successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        }).then(() => window.location.href = '/admin/view/patients');
                    }
                }
            });

        });
    });
</script>
@endsection
