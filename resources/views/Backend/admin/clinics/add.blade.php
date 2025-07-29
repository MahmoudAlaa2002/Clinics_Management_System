@extends('Backend.master')

@section('title' , 'Add New Clinic')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Clinic</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_clinic') }}">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Clinic Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="name" name="name">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="location" name="location">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Clinic Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="phone" name="phone">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Doctor in Charge</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                    </div>
                                    <select class="form-control" id="doctor_id" name="doctor_id">
                                        <option value="" disabled selected hidden>Select Doctor</option>
                                        @if(isset($doctors) && $doctors->count() > 0)
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Opening Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="opening_time" class="form-control" style="direction: ltr; text-align: left;" lang="en" id="opening_time">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Closing Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="closing_time" class="form-control" style="direction: ltr; text-align: left;" lang="en" id="closing_time">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Working Days <span class="text-danger">*</span></label>
                                <div class="row gx-1">
                                    <div class="col-6">
                                        @php
                                            $left_days = ['Saturday','Sunday','Monday','Tuesday'];
                                        @endphp
                                        @foreach($left_days as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                <label class="form-check-label" for="{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $right_days = ['Wednesday','Thursday','Friday'];
                                        @endphp
                                        @foreach($right_days as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                <label class="form-check-label" for="{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Specialties <span class="text-danger">*</span></label>
                                <div class="row gx-1">
                                    @php
                                        $split = ceil($specialties->count() / 2);
                                        $chunks = $specialties->chunk($split);
                                    @endphp

                                    @foreach($chunks as $chunk)
                                        <div class="col-6">
                                            @foreach($chunk as $specialty)
                                                <div class="form-check">
                                                    <input type="checkbox"
                                                        class="form-check-input"
                                                        id="spec_{{ $specialty->id }}"
                                                        name="specialties[]"
                                                        value="{{ $specialty->id }}"
                                                        {{ isset($clinic) && in_array($specialty->id, $clinic->specialties->pluck('id')->toArray()) ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="spec_{{ $specialty->id }}">
                                                        {{ $specialty->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>Clinic Description </label>
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

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Add Clinic</button>
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

            let name = $('#name').val().trim();
            let location = $('#location').val().trim();
            let phone = $('#phone').val().trim();
            let doctor_id = $('#doctor_id').val();
            let openingTime = $('#opening_time').val();
            let closingTime = $('#closing_time').val();
            let description = $('#description').val().trim();
            let status = $('input[name="status"]:checked').val();

            // مصفوفات
            let workingDays = [];
            $('input[name="working_days[]"]:checked').each(function () {
                workingDays.push($(this).val());
            });

            let specialties = [];
            $('input[name="specialties[]"]:checked').each(function () {
                specialties.push($(this).val());
            });

            // إنشاء formData
            let formData = new FormData();
            formData.append('name', name);
            formData.append('location', location);
            formData.append('phone', phone);
            formData.append('doctor_id', doctor_id);
            formData.append('opening_time', openingTime);
            formData.append('closing_time', closingTime);
            formData.append('description', description);
            formData.append('status', status);

            // إضافة working_days[]
            workingDays.forEach(function (day) {
                formData.append('working_days[]', day);
            });

            // إضافة specialties[]
            specialties.forEach(function (specialty) {
                formData.append('specialties[]', specialty);
            });
            if(name === '' || location === '' || phone === '' || opening_time === '' || closing_time === '' || $('input[name="working_days[]"]:checked').length === 0 || $('input[name="specialties[]"]:checked').length === 0){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter All Required Fields',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }else{
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
                            text: 'This Clinic Already Exists',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else if (response.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Clinic Has Been Added Successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '/add/clinic';
                        });
                    }
                }
            });
        }
    });
    </script>
@endsection
