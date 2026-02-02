@extends('Backend.patients.master')

@section('title', 'Edit Profile')

@section('content')

<section class="py-4 py-lg-5">

<style>

    .edit-wrapper{
        max-width:1150px;
        margin:auto;
    }

    .edit-title{
        font-size:24px;
        font-weight:800;
        color:#1f2b3e;
        margin-bottom:16px;
    }

    .card-block{
        background:#ffffff;
        border-radius:20px;
        border:1px solid #e6ebf5;
        box-shadow:0 18px 35px rgba(0,0,0,.06);
        padding:24px 24px;
        margin-bottom:22px;
    }

    .block-title{
        font-size:20px;
        font-weight:800;
        color:#1f2b3e;
        margin-bottom:14px;
        display:flex;
        gap:8px;
        align-items:center;
    }

    .block-title i{
        color:#00A8FF;
    }

    .form-label{
        font-size:12px;
        font-weight:700;
        color:#5a647d;
        margin-bottom:4px;
        letter-spacing:.03em;
        text-transform:uppercase;
    }

    .form-control{
        border-radius:12px;
        border:1px solid #d9e2f1;
        padding:10px 12px;
        background:#fbfcff;
    }

    .form-control:focus{
        border-color:#00A8FF;
        box-shadow:0 0 0 2px rgba(0,168,255,.15);
        background:#fff;
    }

    .avatar-box{
        text-align:center;
        margin-bottom:14px;
    }

    .avatar-preview{
        width:120px;
        height:120px;
        border-radius:50%;
        object-fit:cover;
        border:4px solid #eef4ff;
        margin-bottom:8px;
    }

    .actions{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:8px;
    }

    .save-btn{
        background:#00A8FF;
        border:none;
        color:#fff;
        padding:10px 22px;
        border-radius:12px;
        font-weight:700;
    }

    .cancel-btn{
        background:#f4f7fc;
        border:1px solid #d9e2f1;
        padding:10px 20px;
        border-radius:12px;
        font-weight:700;
        color:#4b5563;
    }

</style>


<div class="edit-wrapper">

    <form action="{{ route('patient.update_profile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="edit-title">Edit Profile</div>

    {{-- ====================== BASIC INFO CARD ====================== --}}
    <div class="card-block">

        <div class="block-title">
            <i class="fa-solid fa-user"></i> Basic Information
        </div>

        {{-- PHOTO --}}
        <div class="avatar-box">
            <img src="{{ asset('storage/'.auth()->user()->image ?? 'assets/img/user.jpg') }}"
                class="avatar-preview">

            <div>
                <label class="form-label">Change Profile Picture</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
        </div>

        <div class="row gy-3">

            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', auth()->user()->name) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', auth()->user()->email) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control"
                    value="{{ old('phone', auth()->user()->phone) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="{{ old('address', auth()->user()->address) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <div class="d-flex gap-4" style="margin-top: 10px;">
                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" id="gender" name="gender" value="Male"
                            {{ auth()->user()->gender == 'Male' ? 'checked' : '' }}>
                        Male
                    </label>

                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" id="gender" name="gender" value="Female"
                            {{ auth()->user()->gender == 'Female' ? 'checked' : '' }}>
                        Female
                    </label>

                </div>
            </div>


        </div>

    </div>


    {{-- ====================== MEDICAL CARD ====================== --}}
    <div class="card-block">

        <div class="block-title">
            <i class="fa-solid fa-heart-pulse"></i> Medical Information
        </div>

        <div class="row gy-3">

            <div class="col-md-6">
                <label class="form-label">Emergency Contact</label>
                <input type="text" id="emergency_contact" name="emergency_contact" class="form-control"
                    value="{{ old('emergency_contact', $patient->emergency_contact) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Blood Type</label>
                <select id="blood_type" name="blood_type" class="form-control">
                    <option value="">Select</option>

                    <option value="A+"  {{ $patient->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-"  {{ $patient->blood_type == 'A-' ? 'selected' : '' }}>A-</option>

                    <option value="B+"  {{ $patient->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-"  {{ $patient->blood_type == 'B-' ? 'selected' : '' }}>B-</option>

                    <option value="AB+" {{ $patient->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ $patient->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>

                    <option value="O+"  {{ $patient->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-"  {{ $patient->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
            </div>


            <div class="col-12">
                <label class="form-label">Chronic Diseases</label>
                <textarea id="chronic_diseases" name="chronic_diseases" rows="3" class="form-control">{{ old('chronic_diseases', $patient->chronic_diseases) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Allergies</label>
                <textarea id="allergies" name="allergies" rows="3" class="form-control">{{ old('allergies', $patient->allergies) }}</textarea>
            </div>

        </div>

</div>

<input type="hidden" id="orig_name" value="{{ auth()->user()->name }}">
<input type="hidden" id="orig_email" value="{{ auth()->user()->email }}">
<input type="hidden" id="orig_phone" value="{{ auth()->user()->phone }}">
<input type="hidden" id="orig_address" value="{{ auth()->user()->address }}">
<input type="hidden" id="orig_gender" value="{{ auth()->user()->gender }}">
<input type="hidden" id="orig_date_of_birth" value="{{ auth()->user()->date_of_birth }}">

<input type="hidden" id="orig_emergency" value="{{ $patient->emergency_contact }}">
<input type="hidden" id="orig_blood" value="{{ $patient->blood_type }}">
<input type="hidden" id="orig_chronic" value="{{ $patient->chronic_diseases }}">
<input type="hidden" id="orig_allergies" value="{{ $patient->allergies }}">

{{-- ACTION BUTTONS --}}
<div class="actions">
    <a href="{{ route('patient.view_profile') }}" class="cancel-btn">
        Cancel
    </a>

    <button type="submit" class="save-btn">
        Save Changes
    </button>
</div>

</form>

</div>

</section>

@endsection

@section('js')
<script>
    $(document).ready(function () {

        $('.save-btn').click(function (e) {
            e.preventDefault();

            let name          = $('#name').val().trim();
            let email         = $('#email').val().trim();
            let phone         = $('#phone').val().trim();
            let address       = $('#address').val().trim();
            let gender        = $('input[name="gender"]:checked').val();
            let date_of_birth = $('#date_of_birth').val();

            let emergency  = $('#emergency_contact').val().trim();
            let blood_type = $('#blood_type').val();
            let chronic    = $('#chronic_diseases').val().trim();
            let allergies  = $('#allergies').val().trim();


            let imgInput = document.querySelector('#image');

            // ================= REQUIRED FIELDS =================
            if (!name || !email || !phone || !gender || !date_of_birth) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter all required fields',
                    icon: 'error',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }


            // ================= NO CHANGES =================
            let noChanges =
                name === $('#orig_name').val() &&
                email === $('#orig_email').val() &&
                phone === $('#orig_phone').val() &&
                address === $('#orig_address').val() &&
                gender === $('#orig_gender').val() &&
                date_of_birth === $('#orig_date_of_birth').val() &&
                emergency === $('#orig_emergency').val() &&
                blood_type === $('#orig_blood').val() &&
                chronic === $('#orig_chronic').val() &&
                allergies === $('#orig_allergies').val() &&
                !(imgInput && imgInput.files.length > 0);

            if (noChanges) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'No Changes',
                    text: 'No updates were made to your profile',
                    confirmButtonColor: '#00A8FF'
                });
            }

            // ================= FormData =================
            let formData = new FormData();
            formData.append('_method', 'PUT');

            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('address', address);
            formData.append('gender', gender);
            formData.append('date_of_birth', date_of_birth);
            formData.append('emergency_contact', emergency);
            formData.append('blood_type', blood_type);
            formData.append('chronic_diseases', chronic);
            formData.append('allergies', allergies);

            if (imgInput && imgInput.files.length > 0) {
                formData.append('image', imgInput.files[0]);
            }

            // ================= CHECK EMAIL (RFC + DNS) =================
            $.ajax({
                method: 'POST',
                url: "{{ route('check_email') }}",
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function () {

                    // ========== IF EMAIL OK → UPDATE ==========
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('patient.update_profile') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function (res) {

                            if (res.data == 0) {
                                return Swal.fire({
                                    icon: 'error',
                                    title: 'Email already exists',
                                    text: 'Please choose another email',
                                    confirmButtonColor: '#00A8FF'
                                });
                            }

                            if (res.data == 1) {
                                return Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Profile updated successfully',
                                    confirmButtonColor: '#00A8FF'
                                }).then(() => {
                                    window.location.href = '/patient/profile';
                                });
                            }
                        },

                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unexpected error',
                                text: 'Please try again later',
                                confirmButtonColor: '#00A8FF'
                            });
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
