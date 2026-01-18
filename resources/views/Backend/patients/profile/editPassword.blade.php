@extends('Backend.patients.master')

@section('title', 'Edit Password')

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

    <form action="{{ route('patient.update_password') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="edit-title">Edit Password</div>


        {{-- ====================== PASSWORD CARD ====================== --}}
        <div class="card-block">

            <div class="block-title">
                <i class="fa-solid fa-lock"></i> Password Settings
            </div>

            <div class="row gy-3">

                <div class="col-md-4">
                    <label class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

            </div>

        </div>


    </div>


    {{-- ACTION BUTTONS --}}
    <div class="actions" style="margin-right: 180px;">
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

            let currentPass = $('#current_password').val();
            let password    = $('#password').val();
            let confirmPass = $('#password_confirmation').val();

            // ================= PASSWORD REGEX =================
            let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

            if (!currentPass || !password || !confirmPass) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter all required fields',
                    icon: 'error',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }

            if (password) {

                if (!currentPass) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Current password required',
                        text: 'Please enter your current password',
                        confirmButtonColor: '#00A8FF'
                    });
                }

                if (!passwordPattern.test(password)) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Invalid Password',
                        text: 'Password must be 6–15 characters',
                        confirmButtonColor: '#00A8FF'
                    });
                }

                if (password !== confirmPass) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Password mismatch',
                        text: 'Password confirmation does not match',
                        confirmButtonColor: '#00A8FF'
                    });
                }
            }

            // ================= FormData =================
            let formData = new FormData();
            formData.append('_method', 'PUT');

            if (password) {
                formData.append('current_password', currentPass);
                formData.append('password', password);
                formData.append('password_confirmation', confirmPass);
            }

            // فقط تم تصحيح المسار الخاطئ
            $.ajax({
                method: 'POST',
                url: "{{ route('patient.update_password') }}",   // ← كان خطأ
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
                            title: 'Wrong password',
                            text: 'Current password is incorrect',
                            confirmButtonColor: '#00A8FF'
                        });
                    }

                    if (res.data == 1) {
                        return Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password updated successfully',
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

        });

    });
</script>
@endsection
