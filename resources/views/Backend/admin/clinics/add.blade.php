@extends('Backend.admin.master')

@section('title' , 'Add New Clinic')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    .card-header { font-weight: 600; }
    input[type="time"] { direction: ltr; text-align: left; }

    .small-gutter > [class^="col-"] {
        padding-left: 30px !important;
        margin-top: 15px !important;
    }

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
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Clinic</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_clinic') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- 1) Basic Info --}}
                    <div class="card">
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Clinic Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="name" name="name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="location" name="location">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Clinic Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" id="email" name="email">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Clinic Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="phone" name="phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Working Schedule (Hours + Days) --}}
                    <div class="card">
                        <div class="card-header">Working Schedule</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Opening Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="time" name="opening_time" class="form-control" lang="en" id="opening_time">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Closing Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="time" name="closing_time" class="form-control" lang="en" id="closing_time">
                                    </div>
                                </div>

                                <div class="row small-gutter">
                                    <div class="col-sm-12">
                                        <label>Working Days <span class="text-danger">*</span></label>
                                        <div class="row gx-1">
                                            <div class="col-6">
                                                @php $left_days = ['Saturday','Sunday','Monday','Tuesday']; @endphp
                                                @foreach($left_days as $day)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                        <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-6">
                                                @php $right_days = ['Wednesday','Thursday','Friday']; @endphp
                                                @foreach($right_days as $day)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                        <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3) Departments --}}
                    <div class="card">
                        <div class="card-header">Departments</div>
                        <div class="card-body">
                            <label>Departments <span class="text-danger">*</span></label>
                            <div class="row gx-1">
                                @php
                                    $split = ceil($departments->count() / 2);
                                    $chunks = $departments->chunk($split);
                                @endphp

                                @foreach($chunks as $chunk)
                                    <div class="col-6">
                                        @foreach($chunk as $department)
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input"
                                                    id="spec_{{ $department->id }}"
                                                    name="departments[]"
                                                    value="{{ $department->id }}"
                                                    {{ isset($clinic) && in_array($department->id, $clinic->departments->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="spec_{{ $department->id }}">
                                                    {{ $department->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- 4) Payment Information --}}
                    <div class="card">
                        <div class="card-header">Payment Information</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- QR Image --}}
                                <div class="col-sm-6">
                                    <label>Payment QR Code</label>
                                    <input type="file" name="qr_image" id="qr_image" class="form-control" accept="image/*">
                                    <small class="text-muted">
                                        Upload the clinic’s official Bank / PalPay QR code
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 5) Description & Status --}}
                    <div class="card">
                        <div class="card-header">Description & Status</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Clinic Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the clinic...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="clinic_active" value="active" checked>
                                    <label class="form-check-label" for="clinic_active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="clinic_inactive" value="inactive">
                                    <label class="form-check-label" for="clinic_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Submit --}}
                    <div class="text-center m-t-20" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">
                            Add Clinic
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
    $('.addBtn').click(function (e) {
        e.preventDefault();

        let name          = $('#name').val().trim();
        let location      = $('#location').val().trim();
        let email         = $('#email').val().trim();
        let phone         = $('#phone').val().trim();
        let opening_time  = $('#opening_time').val();
        let closing_time  = $('#closing_time').val();
        let description   = $('#description').val().trim();
        let status        = $('input[name="status"]:checked').val();
        let qrImage = document.getElementById('qr_image').files[0];

        // مصفوفات
        let workingDays = [];
        $('input[name="working_days[]"]:checked').each(function () {
            workingDays.push($(this).val());
        });

        let departments = [];
        $('input[name="departments[]"]:checked').each(function () {
            departments.push($(this).val());
        });

        // إنشاء formData
        let formData = new FormData();
        formData.append('name', name);
        formData.append('location', location);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('opening_time', opening_time);
        formData.append('closing_time', closing_time);
        formData.append('description', description);
        formData.append('status', status);

        workingDays.forEach(day => formData.append('working_days[]', day));
        departments.forEach(dep => formData.append('departments[]', dep));

        if (qrImage) {
            formData.append('qr_image', qrImage);
        }


        // ===== التحقق من الحقول المطلوبة =====
        if (name === '' || location === '' || email === '' || phone === '' || opening_time === '' || closing_time === ''
            || workingDays.length === 0 || departments.length === 0 ) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter all required fields',
                icon: 'error',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // ===== فحص الوقت =====
        if (opening_time >= closing_time) {
            Swal.fire({
                title: 'Error!',
                text: 'The timing is incorrect, please correct it',
                icon: 'error',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        // ===== فحص الإيميل الحقيقي (Laravel RFC + DNS) =====
        $.ajax({
            method: 'POST',
            url: "{{ route('check_email') }}",
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {

                // الإيميل صحيح → نرسل الطلب لإنشاء العيادة
                $.ajax({
                    method: 'POST',
                    url: "{{ route('store_clinic') }}",
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
                                text: 'This clinic already exists',
                                icon: 'error',
                                confirmButtonColor: '#00A8FF',
                            });

                        } else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Clinic has been added successfully',
                                icon: 'success',
                                confirmButtonColor: '#00A8FF',
                            }).then(() => {
                                window.location.href = '/admin/view/clinics';
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
</script>
@endsection
